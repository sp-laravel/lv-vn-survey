<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Encuesta_docente;
use App\Models\Encuesta_docente_pregunta;
use App\Models\Encuesta_pregunta_opcion;
use App\Models\Encuesta_tutor_pregunta;
use App\Models\Horario_docente;
use App\Models\Sede_director;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class WelcomeController extends Controller {
  public function __invoke() {
    // Data
    $name = Auth::user()->name;
    $email = Auth::user()->email;
    $dni = Auth::user()->persona_dni;
    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $timeNow = $datetimeNow->toTimeString();
    $todayDayFormat = Carbon::today()->format('l');
    $todayDay = ucfirst(Carbon::parse($todayDayFormat)->locale('es')->dayName);
    // $todayDay = "Lunes";
    $superAdmins = Administrador::SUPERADMINS;
    $admins = Administrador::orderBy('id')->get();
    $sedes = Sede_director::orderBy('id', 'asc')->get();
    $todayHour = date('H:i:s');
    $surveyTimeStart = Administrador::TIMESURVEYSTART * 60;
    $surveyTimeEnd = Administrador::TIMESURVEYEND * 60;
    $config = false;
    $configFull = false;
    $horariesStatus = [];
    $cyclesMerge = [];
    $horaryTimes = [];
    $horaryIdsMerge = [];
    $sedeMerge = [];
    $listDirectors = [];
    $lisTAdmins = [];

    // Get list of directors
    foreach ($sedes as $sede) {
      array_push($listDirectors, $sede->email_director);
    }

    // Get list of admins
    foreach ($admins as $admin) {
      array_push($lisTAdmins, $admin->email);
    }

    // Get Role
    $perfil = DB::select("SELECT 
        tuse.name AS usuario, trol.name AS rol
      FROM public.users tuse
        LEFT JOIN public.model_has_roles tmod ON tuse.id = tmod.model_id
        LEFT JOIN public.roles trol ON tmod.role_id = trol.id
      WHERE tuse.id = '" . Auth::user()->id . "'  
    ");
    $role = strtolower($perfil[0]->rol);

    // Validate Access Admin
    if (in_array($email, $lisTAdmins)) {
      $config = true;
    }
    // Validate Access Admin Full
    if (in_array($email, $superAdmins)) {
      $configFull = true;
    }

    // Validate Director ********************************************************/
    if ($role == 'coordinador') {
      // Data
      $query = "";
      $sede = Sede_director::where('email_director', $email)->get();

      // Validate Director/Sede
      foreach ($sede as $sed) {
        array_push($sedeMerge, $sed->sede);
      }
      $query = "'" . implode("','", $sedeMerge) . "'";

      // Get cycles by Director
      $cycles = DB::select("SELECT DISTINCT
          dus1.dni as dni_tutor,
          us1.email as email_tutor,
          initcap(dus1.apellido_paterno||' '||dus1.apellido_materno)  as apellido_tutor,
          initcap(dus1.nombres) as nombre_tutor,
          au.codigo_aula as codigo_final,
          lo.nombre as sede,
          concat_ws('',0) AS estado
        FROM alumno_matricula am
          INNER JOIN aulas au ON au.id = am.aula_id
          LEFT JOIN users us1 ON us1.id = au.tutor_id 
          LEFT JOIN personas dus1 ON dus1.dni = us1.persona_dni
          INNER JOIN matriculas ma ON ma.id=au.matricula_id
          INNER JOIN locales lo ON lo.id = ma.local_id
        WHERE 
          am.estado IN(2,3) 
          AND am.estado_aula=1 
          AND au.codigo_aula <> ''
          AND au.codigo_aula IS NOT NULL 
          AND us1.email IS NOT NULL 
          AND  lo.nombre IN(" . $query . " )
        ORDER BY apellido_tutor
      ");

      // Get Status by Tutor
      $tutorStatus =  DB::connection('pgsql2')->table('estado_encuesta_tutores')
        ->where('email_coordinador', $email)
        ->where('fecha', $dateNow)
        ->get();


      // Get Cycle Active Tutor
      foreach ($cycles as $cycle) {
        foreach ($tutorStatus as $tutorStatu) {
          if ($cycle->codigo_final == $tutorStatu->aula && $tutorStatu->estado == 1) {
            $cycle->estado = 1;
          }
        }
      }

      // Get Questions Tutor
      $questions = Encuesta_tutor_pregunta::orderBy('numero_pregunta')->get();
      $options = Encuesta_pregunta_opcion::where('tipo', 'tutor')->orderBy('indice')->get();

      return view('director.index', compact('role', 'cycles', 'config', 'questions', 'options', 'configFull'));
    } else if ($role == 'tutor') {
      // Get Tutor Info
      $cycles = DB::select("SELECT DISTINCT
            dus1.dni as dni_tutor,
            us1.email as email_tutor,
            initcap(dus1.apellido_paterno||' '||dus1.apellido_materno)  as apellido_tutor,
            initcap(dus1.nombres) as nombre_tutor,
            au.codigo_aula as codigo_final
          FROM alumno_matricula am
            INNER JOIN aulas au ON au.id = am.aula_id
            LEFT JOIN users us1 ON us1.id = au.tutor_id 
            LEFT JOIN personas dus1 ON dus1.dni = us1.persona_dni
          WHERE 
            am.estado IN(2,3) 
            AND am.estado_aula=1 
            AND au.codigo_aula <> ''
            AND au.codigo_aula IS NOT NULL
            AND dus1.dni = '" . $dni . "'  
        ");

      // Merge Cycles
      foreach ($cycles as $cycle) {
        array_push($cyclesMerge, $cycle->codigo_final);
      }
      $cyclesString = "'" . implode("','", $cyclesMerge) . "'";

      // Get Horaries by Cycles Horary Teachers
      $horaries = DB::connection('pgsql2')->select("SELECT 
          id, dia, aula, docente, asignatura, h_inicio, h_fin,
          CASE
            WHEN TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME < h_fin THEN 'Por tomar'
            WHEN TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME >= h_fin
            AND TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME <= TO_TIMESTAMP((to_char(h_fin + INTERVAL '" . $surveyTimeEnd . "','HH24:MI:SS')), 'HH24:MI:SS')::TIME THEN 'Encuestando'
            ELSE 'No tomada'
          END AS proceso,
          estado
        FROM 
          horario_docentes
        WHERE 
          aula IN( " . $cyclesString . ") 
          AND dia = '" . $todayDay . "'
        ORDER BY h_fin ASC
      ");

      // Get Cycle Active Teacher
      foreach ($horaries as $horary) {
        $horaryStartAdd = strtotime($horary->h_fin) - $surveyTimeStart;
        $horaryStart = date('H:i', $horaryStartAdd);
        $horary->h_fin = $horaryStart;

        $horaryEndAdd = strtotime($horary->h_fin) + $surveyTimeEnd;
        $horaryEnd = date('H:i', $horaryEndAdd);
        $horary->h_inicio = $horaryEnd;

        array_push($horaryTimes, $horary->h_fin, $horary->h_inicio);
        array_push($horaryIdsMerge, $horary->id);
      }
      $horaryIds = "'" . implode("','", $horaryIdsMerge) . "'";

      // Get Questions Tutor
      $questions = Encuesta_docente_pregunta::orderBy('numero_pregunta')->get();
      $options = Encuesta_pregunta_opcion::where('tipo', 'docente')->orderBy('indice')->get();

      return view('tutor.index', compact('role', 'horaries', 'horaryTimes', 'questions', 'options', 'config', 'configFull'));
    } else if ($role == "alumno" && is_numeric($name)) {
      // Data
      $cycleActive = [];
      $courseSurveySent = 0;
      $type = "";

      // Get cycles by DNI
      $cycles = DB::select("SELECT DISTINCT
            palu.dni AS dni_alumno,
            al.email AS email_alumno,
            initcap(palu.apellido_paterno||' '||palu.apellido_materno) AS apellido_alumno,
            initcap(palu.nombres) AS nombre_alumno,
            au.codigo_aula as codigo_final
          FROM alumno_matricula am
            INNER JOIN aulas au ON au.id = am.aula_id
            INNER JOIN alumnos al ON al.codigo = am.alumno_codigo
            INNER JOIN personas palu ON palu.dni = al.persona_dni
            LEFT JOIN users us1 ON us1.id = au.tutor_id 
            LEFT JOIN personas dus1 ON dus1.dni = us1.persona_dni
          WHERE 
            am.estado IN(2,3) 
            AND am.estado_aula=1 
            AND au.codigo_aula <> ''
            AND au.codigo_aula IS NOT NULL
            AND palu.dni = '" . $dni . "'  
        ");

      // Merge Cycles
      foreach ($cycles as $cycle) {
        array_push($cyclesMerge, $cycle->codigo_final);
      }
      $cyclesString = "'" . implode("','", $cyclesMerge) . "'";

      // Get Horaries by Cycles Horary Teachers
      $horaries = DB::connection('pgsql2')->select("SELECT 
            id, dia, aula, docente, asignatura, h_inicio, h_fin,
            CASE
              WHEN TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME < h_fin THEN 'Por tomar'
              WHEN TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME >= h_fin
              AND TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME <= TO_TIMESTAMP((to_char(h_fin + INTERVAL '" . $surveyTimeEnd . "','HH24:MI:SS')), 'HH24:MI:SS')::TIME THEN 'Encuestando'
              ELSE 'Tomada'
            END AS proceso,
            estado
          FROM 
            horario_docentes
          WHERE 
            aula IN( " . $cyclesString . ") 
            AND dia = '" . $todayDay . "'
          ORDER BY h_fin ASC
        ");

      // Get Cycle Active Teacher
      foreach ($horaries as $horary) {
        $horaryStartAdd = strtotime($horary->h_fin) - $surveyTimeStart;
        $horaryStart = date('H:i', $horaryStartAdd);
        $horary->h_fin = $horaryStart;

        $horaryEndAdd = strtotime($horary->h_fin) + $surveyTimeEnd;
        $horaryEnd = date('H:i', $horaryEndAdd);
        $horary->h_inicio = $horaryEnd;

        // if ($todayHour >= $horary->h_fin && $todayHour <= $horary->h_inicio || $horary->estado == 1) {
        if ($horary->estado == 1) {
          array_push($cycleActive, $horary->id, $horary->aula, $horary->docente, $horary->asignatura, $horary->h_fin, $horary->h_inicio);
        }
        array_push($horaryTimes, $horary->h_fin, $horary->h_inicio);
      }

      // Get survey sent
      if (count($cycleActive) >= 1) {
        // Survey Sent
        $surveySent = DB::connection('pgsql2')->select("SELECT 
            id
          FROM 
            encuesta_docentes
          WHERE 
            dni_alumno = '" . Auth::user()->name . "'
            AND fecha = '" . $dateNow . "'
            AND docente = '" . $cycleActive[2] . "'
            AND curso = '" . $cycleActive[3] . "'
        ");
        $courseSurveySent =  count($surveySent);
        $type = "docente";
        $questions = Encuesta_docente_pregunta::orderBy('numero_pregunta')->get();
      } else {
        // Get Cycle Active Tutor
        $SurveyActives = DB::connection('pgsql2')->select("SELECT 
              id, aula, dni_tutor, estado
            FROM 
              estado_encuesta_tutores
            WHERE 
              aula IN( " . $cyclesString . ") 
              AND fecha = '" . $dateNow . "'
              AND estado = 1
          ");

        // Cycles Active
        foreach ($SurveyActives as $SurveyActive) {
          array_push($cycleActive, $SurveyActive->id, $SurveyActive->aula, $SurveyActive->dni_tutor);
        }

        // Survey Sent
        if (count($SurveyActives) >= 1) {
          $surveySent = DB::connection('pgsql2')->select("SELECT 
                id
              FROM 
                encuesta_tutores
              WHERE 
                dni_alumno = '" . Auth::user()->name . "'
                AND fecha = '" . $dateNow . "'
                AND aula = '" . $cycleActive[1] . "'
            ");
          $courseSurveySent =  count($surveySent);
        }

        $type = "tutor";
        $questions = Encuesta_tutor_pregunta::orderBy('numero_pregunta')->get();
      }

      // return view('welcome2', compact('role', 'dni', 'cycleActive', 'courseSurveySent', 'horaryTimes', 'type', 'questions'));
      return view('alumn.index', compact('role', 'dni', 'cycleActive', 'courseSurveySent', 'horaryTimes', 'type', 'questions'));
    } else {
      if (in_array($email, $superAdmins) || in_array($email, $admins)) {
        return redirect()->route('dashboard');
      }
      Auth::logout();
      return redirect()->route('login')->with('success', 'Usuario no autorizado');
    }
  }
}