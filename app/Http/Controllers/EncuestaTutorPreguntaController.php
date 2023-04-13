<?php

namespace App\Http\Controllers;

use App\Models\Encuesta_tutor_pregunta;
use Illuminate\Http\Request;

class EncuestaTutorPreguntaController extends Controller {
  public function show() {
    $tutors = Encuesta_tutor_pregunta::orderBy('numero_pregunta')->get();
    return view('tutor.index', compact('tutors'));
  }

  public function store(Request $request) {
    if ($request->ajax()) {
      $teacher = new Encuesta_tutor_pregunta;
      $teacher->numero_pregunta = $request->input('numero_pregunta');
      $teacher->pregunta = $request->input('pregunta');
      $teacher->save();

      return response($teacher);
    }
  }

  public function update(Request $request) {
    if ($request->ajax()) {
      $teacher = Encuesta_tutor_pregunta::find($request->id);
      $teacher->numero_pregunta = $request->input('numero_pregunta');
      $teacher->pregunta = $request->input('pregunta');
      $teacher->update();
      return response($teacher);
    }
  }

  public function destroy(Request $request) {
    if ($request->ajax()) {
      Encuesta_tutor_pregunta::destroy($request->id);
    }
  }
}