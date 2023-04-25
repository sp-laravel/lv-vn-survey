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
}