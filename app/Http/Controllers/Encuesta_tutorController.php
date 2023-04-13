<?php

namespace App\Http\Controllers;

use App\Models\Encuesta_tutor;
use App\Models\Estado_encuesta_tutor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Encuesta_tutorController extends Controller {
  public function store(Request $request) {
    // return $request->all();

    // Get Dates
    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $timeNow = $datetimeNow->toTimeString();

    // Validate Survey Status
    $tutor =  Estado_encuesta_tutor::where('id', $request->id)->get();
    $tutorStatus =  $tutor[0]->estado;

    if ($tutorStatus == 0) {
      return redirect('/')->with('error', 'La encuesta ha finalizado');
    } else {
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
    }
  }
}