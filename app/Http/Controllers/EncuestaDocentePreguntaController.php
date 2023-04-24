<?php

namespace App\Http\Controllers;

use App\Models\Encuesta_docente_pregunta;
use Illuminate\Http\Request;

class EncuestaDocentePreguntaController extends Controller {
  public function show() {
    $teachers = Encuesta_docente_pregunta::orderBy('numero_pregunta')->get();
    return view('questions.teacher', compact('teachers'));
  }

  public function store(Request $request) {
    if ($request->ajax()) {
      $teacher = new Encuesta_docente_pregunta;
      $teacher->numero_pregunta = $request->input('numero_pregunta');
      $teacher->pregunta = $request->input('pregunta');
      $teacher->save();

      return response($teacher);
    }
  }

  public function update(Request $request) {
    if ($request->ajax()) {
      $teacher = Encuesta_docente_pregunta::find($request->id);
      $teacher->numero_pregunta = $request->input('numero_pregunta');
      $teacher->pregunta = $request->input('pregunta');
      $teacher->update();
      return response($teacher);
    }
  }

  public function destroy(Request $request) {
    if ($request->ajax()) {
      Encuesta_docente_pregunta::destroy($request->id);
    }
  }
}