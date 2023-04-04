<?php

namespace App\Http\Controllers;

use App\Models\Encuesta_docente;
use App\Models\Horario_docente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Encuesta_docenteController extends Controller {
  public function store(Request $request) {
    // return $request->all();
    // return $request->id;

    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $timeNow = $datetimeNow->toTimeString();

    $teacher =  Horario_docente::where('id', $request->id)->get();
    // return $teacher[0]->curso;

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

    return redirect('/')->with('success', 'Encuesta enviada correctamente');
  }
}