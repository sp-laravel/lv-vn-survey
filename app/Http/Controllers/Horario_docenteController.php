<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Horario_docente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Horario_docenteController extends Controller {
  public function update(Request $request) {
    DB::connection('pgsql2')->table('horario_docentes')
      ->where('id', $request->id)
      ->update(['estado' => $request->status]);

    $response =  DB::connection('pgsql2')->table('horario_docentes')
      ->where('id', $request->id)
      ->get();
    $responseStatus = $response[0]->estado;

    return response()->json(array('msg' => $responseStatus), 200);
  }

  public function activate() {
    // Get Dates
    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $timeNow = $datetimeNow->toTimeString();
    $todayDayFormat = Carbon::today()->format('l');
    $todayDay = ucfirst(Carbon::parse($todayDayFormat)->locale('es')->dayName);
    // $todayDay = "Lunes";
    $timeNowMinute = date("H:i");
    $idHorary = [];
    $idHoraryOff = [];
    $aulasSelected = [];
    $emailTemp = "";

    $surveyTimeStart = Administrador::TIMESURVEYSTART * 60;
    $surveyTimeEnd = Administrador::TIMESURVEYEND * 60;

    $horaries = Horario_docente::where('dia', $todayDay)->get();
    $countStart = 0;
    $countEnd = 0;

    // Group horaries
    foreach ($horaries as $horary) {
      $horaryStartAdd = strtotime($horary->h_fin) - $surveyTimeStart;
      $horaryStart = date('H:i', $horaryStartAdd);
      $horary->h_fin = $horaryStart;

      $horaryEndAdd = strtotime($horary->h_fin) + $surveyTimeEnd;
      $horaryEnd = date('H:i', $horaryEndAdd);
      $horary->h_inicio = $horaryEnd;

      if ($timeNowMinute == $horary->h_fin) {
        $countStart++;
        array_push($idHorary, $horary->id);

        // Get email tutor by Classroom
        $tutors = DB::select("SELECT DISTINCT
            us1.email as email_tutor,
            au.codigo_aula as codigo_final
          FROM alumno_matricula am
            INNER JOIN aulas au ON au.id = am.aula_id
            LEFT JOIN users us1 ON us1.id = au.tutor_id 
            LEFT JOIN personas dus1 ON dus1.dni = us1.persona_dni
            INNER JOIN matriculas ma ON ma.id=au.matricula_id
          WHERE 
            am.estado IN(2,3,9) 
            AND am.estado_aula=1 
            AND au.codigo_aula <> ''
            AND au.codigo_aula IS NOT NULL 
            AND us1.email IS NOT NULL 
            AND au.codigo_aula = '" . $horary->aula . "' 
        ");

        if (count($tutors) >= 1) {
          $emailTemp =  $tutors[0]->email_tutor;
        }

        // Get Classrooms by email
        $cycles = DB::select("SELECT DISTINCT
            au.codigo_aula as codigo_final
          FROM alumno_matricula am
            INNER JOIN aulas au ON au.id = am.aula_id
            LEFT JOIN users us1 ON us1.id = au.tutor_id 
            LEFT JOIN personas dus1 ON dus1.dni = us1.persona_dni
            INNER JOIN matriculas ma ON ma.id=au.matricula_id
          WHERE 
            am.estado IN(2,3,9) 
            AND am.estado_aula=1 
            AND au.codigo_aula <> ''
            AND au.codigo_aula IS NOT NULL 
            AND us1.email = '" . $emailTemp . "' 
        ");

        // Gorup Classrooms
        if (count($cycles) >= 1) {
          foreach ($cycles as $cycle) {
            array_push($aulasSelected, $cycle->codigo_final);
          }
        }
      } elseif ($timeNowMinute == $horary->h_inicio) {
        $countEnd++;
        array_push($idHoraryOff, $horary->id);
      }
    }

    // On Start
    if ($countStart >= 1) {
      // Disable All
      DB::connection('pgsql2')->table('horario_docentes')
        ->whereIn('aula', $aulasSelected)
        ->update(['estado' => 0]);

      // Active Time Selected
      DB::connection('pgsql2')->table('horario_docentes')
        ->whereIn('id', $idHorary)
        ->update(['estado' => 1]);
    }

    // Off End
    if ($countEnd >= 1) {
      DB::connection('pgsql2')->table('horario_docentes')
        ->whereIn('id', $idHoraryOff)
        ->update(['estado' => 0]);
    }


    return $idHorary;
  }
}