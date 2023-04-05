<?php

namespace App\Http\Controllers;

use App\Models\Encuesta_docente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class WelcomeController extends Controller {
  public function index() {

    // Data
    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $todayDayFormat = Carbon::today()->format('l');
    $todayDay = ucfirst(Carbon::parse($todayDayFormat)->locale('es')->dayName);
    // $todayDay = "Lunes";
    $name = Auth::user()->name;
    $dni = Auth::user()->persona_dni;
    $todayHour = date('H:i:s');
    $surveyMinutes = 149;
    $surveyTime = $surveyMinutes * 60;
    $horariesStatus = [];
    $cyclesMerge = [];
    $horaryTimes = [];
    $horaryIdsMerge = [];


    $perfil = DB::select("SELECT 
        tuse.name AS usuario, trol.name AS rol
      FROM public.users tuse
        LEFT JOIN public.model_has_roles tmod ON tuse.id = tmod.model_id
        LEFT JOIN public.roles trol ON tmod.role_id = trol.id
      WHERE tuse.id = '" . Auth::user()->id . "'  
    ");
    $role = strtolower($perfil[0]->rol);

    if ($role == 'tutor') {
      // $role = "tutor";
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
          am.estado IN(2,3,9) 
          AND am.estado_aula=1 
          AND au.codigo_aula <> ''
          AND au.codigo_aula IS NOT NULL
          AND dus1.dni = '" . $dni . "'  
      ");

      foreach ($cycles as $cycle) {
        array_push($cyclesMerge, $cycle->codigo_final);
      }

      $cyclesString = "'" . implode("','", $cyclesMerge) . "'";

      $horaries = DB::connection('pgsql2')->select("SELECT 
          id, dia, aula, docente, asignatura, h_inicio, h_fin,
          CASE
            WHEN TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME < h_fin THEN 'Por tomar'
            WHEN TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME >= h_fin
            AND TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME <= TO_TIMESTAMP((to_char(h_fin + INTERVAL '" . $surveyTime . "','HH24:MI:SS')), 'HH24:MI:SS')::TIME THEN 'Encuestando'
            ELSE 'Tomada'
          END AS proceso,
          estado
        FROM 
          horario_docentes
        WHERE 
          aula IN( " . $cyclesString . ") 
          AND dia = '" . $todayDay . "'
        ORDER BY id ASC
      ");

      foreach ($horaries as $horary) {
        $horaryEndAdd = strtotime($horary->h_fin) + $surveyTime;
        $horaryEnd = date('H:i', $horaryEndAdd);
        $horary->h_inicio = $horaryEnd;

        $horaryStart = date('H:i', strtotime($horary->h_fin));
        $horary->h_fin = $horaryStart;

        array_push($horaryTimes, $horary->h_fin, $horary->h_inicio);
        array_push($horaryIdsMerge, $horary->id);
      }

      $horaryIds = "'" . implode("','", $horaryIdsMerge) . "'";

      return view('welcome', compact('role', 'dni', 'horaries', 'horaryTimes', 'horaryIds'));
    } elseif ($role == 'coordinador') {
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
          am.estado IN(2,3,9) 
          AND am.estado_aula=1 
          AND au.codigo_aula <> ''
          AND au.codigo_aula IS NOT NULL 
        ORDER BY codigo_final
      ");

      // dd($cycles);

      return view('welcome', compact('role', 'dni', 'cycles'));
    } else {

      // $role = "alumn";
      $cycleActive = [];

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
          am.estado IN(2,3,9) 
          AND am.estado_aula=1 
          AND au.codigo_aula <> ''
          AND au.codigo_aula IS NOT NULL
          AND palu.dni = '" . $dni . "'  
      ");

      foreach ($cycles as $cycle) {
        array_push($cyclesMerge, $cycle->codigo_final);
      }

      $cyclesString = "'" . implode("','", $cyclesMerge) . "'";

      $horaries = DB::connection('pgsql2')->select("SELECT 
          id, dia, aula, docente, asignatura, h_inicio, h_fin,
          CASE
            WHEN TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME < h_fin THEN 'Por tomar'
            WHEN TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME >= h_fin
            AND TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME <= TO_TIMESTAMP((to_char(h_fin + INTERVAL '" . $surveyTime . "','HH24:MI:SS')), 'HH24:MI:SS')::TIME THEN 'Encuestando'
            ELSE 'Tomada'
          END AS proceso,
          estado
        FROM 
          horario_docentes
        WHERE 
          aula IN( " . $cyclesString . ") 
          AND dia = '" . $todayDay . "'
        ORDER BY id ASC
      ");

      foreach ($horaries as $horary) {
        $horaryEndAdd = strtotime($horary->h_fin) + $surveyTime;
        $horaryEnd = date('H:i', $horaryEndAdd);
        $horary->h_inicio = $horaryEnd;
        $horaryStart = date('H:i', strtotime($horary->h_fin));
        $horary->h_fin = $horaryStart;
        if ($todayHour >= $horary->h_fin && $todayHour <= $horary->h_inicio || $horary->estado == 1) {
          array_push($cycleActive, $horary->id, $horary->aula, $horary->docente, $horary->asignatura, $horary->h_fin, $horary->h_inicio);
          // return dd($cycleActive);
        }
        array_push($horaryTimes, $horary->h_fin, $horary->h_inicio);
      }
      // return dd($horaryTimes);
      // return count($cycleActive);
      // return $cycleActive[2];

      $courseSurveySent = 0;
      if (count($cycleActive) >= 1) {

        $surveySent = DB::connection('pgsql2')->select("SELECT 
            /* id, docente, curso, aula, fecha, hora, n1, n2, n3, n4, dni_alumno */
            id
          FROM 
            encuesta_docentes
          WHERE 
            dni_alumno = '" . Auth::user()->name . "'
            AND fecha = '" . $dateNow . "'
            AND docente = '" . $cycleActive[2] . "'
        ");
        $courseSurveySent =  count($surveySent);
      }

      return view('welcome', compact('role', 'dni', 'cycleActive', 'courseSurveySent', 'horaryTimes'));
    }
  }
}