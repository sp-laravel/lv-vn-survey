<?php

namespace App\Http\Controllers;

use App\Models\Encuesta_tutor;
use App\Models\Estado_encuesta_tutor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Encuesta_tutorController extends Controller {
  public function index(Request $request) {
    $token = config('services.api.survey-token');
    if ($request->token == $token) {

      // Data
      $datetimeNow = Carbon::now();
      $today = $datetimeNow->toDateString();
      $timeNow = $datetimeNow->toTimeString();

      $surveys = Encuesta_tutor::where('fecha', $today)->get();
      $surveysApi = [];
      $surveysList = [];

      foreach ($surveys as $survey) {
        $surveysTemp = [
          'id' => $survey->id,
          'id_alumn' => $survey->dni,
          'tutor_email' => $survey->email,
          'week' => "",
          'day' => "",
          'state' => $survey->estado,
          'date' => $survey->fecha,
          'time' => $survey->hora,
          'cycle' => "",
          'turno' => $survey->turno
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

    // Validate Survey Status
    $tutor =  Estado_encuesta_tutor::where('id', $request->id)->get();
    $tutorStatus =  $tutor[0]->estado;


    // Survey Sent
    $surveySent = DB::connection('pgsql2')->select("SELECT 
        id
      FROM 
        encuesta_tutores
      WHERE 
        dni_alumno = '" . Auth::user()->name . "'
        AND fecha = '" . $dateNow . "'
        AND tutor = '" . $tutor[0]->dni_tutor . "'
        AND aula = '" . $tutor[0]->aula . "'
    ");
    $courseSurveySent =  count($surveySent);

    // if ($tutorStatus == 0) {
    if ($tutorStatus >= 1 && $courseSurveySent < 1) {
      $encuesta_tutor = new Encuesta_tutor();
      $encuesta_tutor->tutor = $tutor[0]->dni_tutor;
      $encuesta_tutor->aula = $tutor[0]->aula;

      $encuesta_tutor->fecha = $dateNow;
      $encuesta_tutor->hora = $timeNow;

      $encuesta_tutor->n1 = $request->n1;
      $encuesta_tutor->n2 = $request->n2;
      $encuesta_tutor->n3 = $request->n3;
      $encuesta_tutor->n4 = $request->n4;
      $encuesta_tutor->n5 = $request->n5;
      $encuesta_tutor->n6 = $request->n6;
      $encuesta_tutor->n7 = $request->n7;
      $encuesta_tutor->n8 = $request->n8;
      $encuesta_tutor->dni_alumno = Auth::user()->name;
      $encuesta_tutor->save();

      return redirect('/')->with('success', 'Encuesta enviada');
    } else {
      return redirect('/')->with('error', 'La encuesta ha finalizado');
    }
  }
}