<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Encuesta_docente_pregunta;
use App\Models\Encuesta_tutor_pregunta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AlumnoController extends Controller {
  public function show() {
    // Data
    $name = Auth::user()->name;
    $email = Auth::user()->email;
    $dni = Auth::user()->persona_dni;
    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $timeNow = $datetimeNow->toTimeString();
    $todayDayFormat = Carbon::today()->format('l');
    // $todayDay = ucfirst(Carbon::parse($todayDayFormat)->locale('es')->dayName);
    $todayDay = "Lunes";
    $surveyTimeStart = Administrador::TIMESURVEYSTART * 60;
    $surveyTimeEnd = Administrador::TIMESURVEYEND * 60;
    $cyclesMerge = [];
    $status = 0;

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
        am.estado IN(2,3,9) 
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

    return view('alumn.form', compact('cycleActive', 'courseSurveySent', 'type', 'questions'));
  }
}