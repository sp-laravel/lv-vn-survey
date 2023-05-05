<?php

namespace App\Http\Controllers;

use App\Models\Encuesta_docente;
use App\Models\Encuesta_docente_control;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncuestaDocenteControlController extends Controller {
  public function index(Request $request) {
    $token = config('services.api.survey-token');
    if ($request->token == $token) {
      $today = $request->date;
      $today = str_replace('"', '', $today);
      $data = Encuesta_docente_control::where('fecha', $today)->get();
      $data->makeHidden(['created_at', 'updated_at']);

      return $data;
    } else {
      return redirect('/');
    }
  }

  public function store() {
    // Data
    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $control = "";
    $count = 0;
    $cycles = [];
    $cantCyclesRow = [];
    $countCycle = 0;
    $data = [];
    $status = 0;

    $surveys = Encuesta_docente::where('fecha', $dateNow)->get();

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

      if ($countCycle < 3) {
        $status = 0;
      } elseif ($countCycle >= 3 && $countCycle <= 9) {
        $status = 2;
      } elseif ($countCycle >= 10) {
        $status = 1;
      }

      // array_push($cantCyclesRow, $countCycle);
      $row = [
        'id' => $count,
        'fecha' => $dateNow,
        'tutor' => $tutor,
        'ciclo' => $cycleName,
        'docente' => $teacher,
        'curso' => $subject,
        'estado' => $status,
        'total_encuestados' => $countCycle,
        'total_alumnos' => count($alumns)
      ];
      // array_push($data, [$count, $today, $tutor, $cycleName, $teacher, $subject, $status, $countCycle, count($alumns)]);
      array_push($data, $row);
      $countCycle = 0;
    }

    foreach ($data as $row) {
      $control = new Encuesta_docente_control;
      $control->fecha = $row['fecha'];
      $control->tutor = $row['tutor'];
      $control->ciclo = $row['ciclo'];
      $control->docente = $row['docente'];
      $control->curso = $row['curso'];
      $control->estado = $row['estado'];
      $control->total_encuestados = $row['total_encuestados'];
      $control->total_alumnos = $row['total_alumnos'];
      $control->save();
    }
    return $data;
  }

  public function api(Request $request) {
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
          $status = 2;
        } elseif ($countCycle >= 10) {
          $status = 1;
        }

        // array_push($cantCyclesRow, $countCycle);
        $row = [
          'id' => $count,
          'fecha' => $today,
          'tutor' => $tutor,
          'ciclo' => $cycleName,
          'docente' => $teacher,
          'curso' => $subject,
          'estado' => $status,
          'total_encuestados' => $countCycle,
          'total_alumnos' => count($alumns)
        ];
        // array_push($data, [$count, $today, $tutor, $cycleName, $teacher, $subject, $status, $countCycle, count($alumns)]);
        array_push($data, $row);
        $countCycle = 0;
      }

      return $data;
    } else {
      return redirect('/');
    }
  }
}