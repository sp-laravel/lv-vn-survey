<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class WelcomeController extends Controller {
  public function index() {

    // Data
    $role = "Admin";
    $dni = Auth::user()->persona_dni;
    $todayHour = date('H:i:s');
    $horariesStatus = [];
    $cyclesMerge = [];
    $surveyMinutes = 10;
    $surveyTime = $surveyMinutes * 60;

    $todayDayFormat = Carbon::today()->format('l');
    //$todayDay = ucfirst(Carbon::parse($todayDayFormat)->locale('es')->dayName);
    $todayDay = "Lunes";

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

    $cycleFirst = $cycles[0]->codigo_final;

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
        END AS status
      FROM 
        horario_docentes
      WHERE 
        aula IN( " . $cyclesString . ") 
        AND dia = '" . $todayDay . "'
    ");

    foreach ($horaries as $horary) {
      $horaryEndAdd = strtotime($horary->h_fin) + $surveyTime;
      $horaryEnd = date('H:i', $horaryEndAdd);
      $horary->h_inicio = $horaryEnd;

      $horaryStart = date('H:i', strtotime($horary->h_fin));
      $horary->h_fin = $horaryStart;
    }

    return view('welcome', compact('role', 'dni', 'horaries'));
  }
}