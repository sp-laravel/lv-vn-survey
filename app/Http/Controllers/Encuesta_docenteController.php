<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Encuesta_docente;
use App\Models\Horario_docente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Encuesta_docenteController extends Controller {
  public function index(Request $request) {
    $token = config('services.api.survey-token');
    if ($request->token == $token) {

      // Data
      $datetimeNow = Carbon::now();
      $today = $request->date;
      // $today = $datetimeNow->toDateString();
      // $today = '2023-05-02';
      $timeNow = $datetimeNow->toTimeString();

      $surveys = Encuesta_docente::where('fecha', $today)->get();
      $surveysApi = [];
      $surveysList = [];

      foreach ($surveys as $survey) {
        $surveysTemp = [
          'id' => $survey->id,
          'docente' => $survey->docente,
          'curso' => $survey->curso,
          'aula' => $survey->aula,
          'fecha' => $survey->fecha,
          'hora' => $survey->hora,
          'n1' => $survey->n1,
          'n2' => $survey->n2,
          'n3' => $survey->n3,
          'n4' => $survey->n4
        ];
        array_push($surveysApi, $surveysTemp);
      }
      return $surveysApi;
    } else {
      return redirect('/');
    }
  }
  public function store(Request $request) {
    // return $request->all();

    // Get Dates
    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $timeNow = $datetimeNow->toTimeString();
    $surveyTimeStart = Administrador::TIMESURVEYSTART * 60;
    $surveyTimeEnd = Administrador::TIMESURVEYEND * 60;
    $surveyTime = false;

    // Validate Survey Status
    $teacher =  Horario_docente::where('id', $request->id)->get();
    $horaryStatus =  $teacher[0]->estado;

    // $h_startAdd = strtotime($teacher[0]->h_fin) - ($surveyTimeStart);
    // $h_start =  date('H:i', $h_startAdd);
    // $h_endAdd = strtotime($teacher[0]->h_fin) + ($surveyTimeEnd);
    // $h_end = date('H:i', $h_endAdd);

    // if ($timeNow >= $h_start && $timeNow <= $h_end) {
    //   $surveyTime = true;
    // }

    // Survey Sent
    $surveySent = DB::connection('pgsql2')->select("SELECT 
        id
      FROM 
        encuesta_docentes
      WHERE 
        dni_alumno = '" . Auth::user()->name . "'
        AND fecha = '" . $dateNow . "'
        AND docente = '" . $teacher[0]->docente . "'
        AND curso = '" . $teacher[0]->asignatura . "'
    ");
    $courseSurveySent =  count($surveySent);

    // if ($horaryStatus >= 1 || $surveyTime == true) {
    if ($horaryStatus >= 1 && $courseSurveySent < 1) {
      // if ($horaryStatus >= 1) {
      $encuesta_docente = new Encuesta_docente();
      $encuesta_docente->docente = $teacher[0]->docente;
      $encuesta_docente->curso = $teacher[0]->asignatura;
      $encuesta_docente->aula = $teacher[0]->aula;

      $encuesta_docente->fecha = $dateNow;
      $encuesta_docente->hora = $timeNow;

      $encuesta_docente->n1 = $request->n1;
      $encuesta_docente->n2 = $request->n2;
      $encuesta_docente->n3 = $request->n3;
      $encuesta_docente->n4 = $request->n4;
      $encuesta_docente->dni_alumno = Auth::user()->name;
      $encuesta_docente->save();

      return redirect('/')->with('success', 'Encuesta enviada');
    } else {
      return redirect('/')->with('error', 'La encuesta ha finalizado');
    }
  }

  public function control(Request $request) {
    $token = config('services.api.survey-token');
    if ($request->token == $token) {
      // Data
      $datetimeNow = Carbon::now();
      $today = $request->date;
      $today = str_replace('"', '', $today);
      $control = "";
      $count = 0;
      $cycles = [];
      $cantCyclesRow = [];
      $countCycle = 0;
      $data = [];
      $status = 0;

      $surveys = Encuesta_docente::where('fecha', $today)->get();

      foreach ($surveys as $survey) {
        $colSubject = $survey->curso;
        $colCycle = $survey->aula;
        $cycleSubject = $colCycle . '-' . $colSubject;

        if (!in_array($cycleSubject, $cycles)) {
          array_push($cycles, $cycleSubject);
        }
      }

      foreach ($cycles as $cycle) {
        $count++;
        $teacher = "";
        $tutor = "";
        $subject = "";
        $cycleName = "";

        foreach ($surveys as $survey) {
          $colSubject = $survey->curso;
          $colCycle = $survey->aula;
          $cycleSubject = $colCycle . '-' . $colSubject;

          if ($cycle == $cycleSubject) {
            $countCycle++;
            $teacher = $survey->docente;
            $subject = $survey->curso;
            $cycleName = $survey->aula;
          }
        }

        $alumns = DB::select("SELECT
            initcap(dus1.apellido_paterno||' '||dus1.apellido_materno)  as apellido_tutor,
            initcap(dus1.nombres) as nombre_tutor,
            us1.email as email_tutor,
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
            AND au.codigo_aula = '" . $cycleName . "'  
        ");
        $tutor = strtoupper($alumns[0]->apellido_tutor) . strtoupper($alumns[0]->nombre_tutor);

        if ($countCycle == 0) {
          $status = 0;
        } elseif ($countCycle >= 3 && $countCycle <= 9) {
          $status = 3;
        } elseif ($countCycle >= 10) {
          $status = 2;
        }

        array_push($cantCyclesRow, $countCycle);
        array_push($data, [$count, $today, $tutor, $cycleName, $teacher, $subject, $status, $countCycle, count($alumns)]);
        $countCycle = 0;
      }

      foreach ($cycles as $cycle) {
        # code...
      }


      $tutors = DB::select("SELECT DISTINCT
          initcap(dus1.apellido_paterno||' '||dus1.apellido_materno)  as apellido_tutor,
          initcap(dus1.nombres) as nombre_tutor,
          us1.email as email_tutor,
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
          AND au.codigo_aula = '" . $cycleName . "'  
      ");


      return $data;
    } else {
      return redirect('/');
    }
  }
}