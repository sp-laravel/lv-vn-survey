<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Encuesta_docente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TutorController extends Controller {
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
        am.estado IN(2,3,9) 
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
          WHEN TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME < TO_TIMESTAMP((to_char(h_fin - INTERVAL '" . $surveyTimeEnd . "','HH24:MI:SS')), 'HH24:MI:SS')::TIME THEN 'Por encuestar'
          WHEN TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME >= TO_TIMESTAMP((to_char(h_fin - INTERVAL '" . $surveyTimeEnd . "','HH24:MI:SS')), 'HH24:MI:SS')::TIME
          AND TO_TIMESTAMP(to_char(now(),'HH24:MI:SS'), 'HH24:MI:SS')::TIME <= TO_TIMESTAMP((to_char(h_fin + INTERVAL '" . $surveyTimeEnd . "','HH24:MI:SS')), 'HH24:MI:SS')::TIME THEN 'Encuestando'
          ELSE 'No encuestado'
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

      // PROCESO
      $quantitySurvey = Encuesta_docente::where('fecha', $dateNow)
        ->where('docente', $horary->docente)
        ->where('aula', $horary->aula)
        ->where('curso', $horary->asignatura)
        ->get();
      // if (count($status) >= 1 && $horary->proceso == 'No encuestado') {
      if ($horary->estado >= 1) {
        $horary->proceso = "Encuestando";
      } elseif (count($quantitySurvey) >= 1) {
        $horary->proceso = "Encuestado";
      } else {
        if ($timeNow < $horary->h_fin) {
          $horary->proceso = "Por encuestar";
          // } else if ($timeNow >= $horary->h_fin && $timeNow <= $horary->h_inicio) {
          // } else if ($horary->estado == 1) {
          //   $horary->proceso = "Encuestando";
        } else {
          $horary->proceso = "No encuestado";
        }
      }

      // array_push($horaryTimes, $horary->h_fin, $horary->h_inicio);
      // array_push($horaryIdsMerge, $horary->id);
    }
    return view('tutor.list', compact('horaries'));
  }
}