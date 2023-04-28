<?php

namespace App\Http\Controllers;

use App\Models\Encuesta_pregunta_opcion;
use Illuminate\Http\Request;

class Encuesta_pregunta_opcionController extends Controller {
  public function show(Request $request) {
    $type = $request->type;
    $options = Encuesta_pregunta_opcion::where('tipo', $type)->orderBy('indice')->get();
    return view('questions.option', compact('options'));
  }

  public function store(Request $request) {
    if ($request->ajax()) {
      $option = new Encuesta_pregunta_opcion;
      $option->indice = $request->input('index_option');
      $option->opcion = $request->input('name_option');
      $option->valor = $request->input('value_option');
      $option->tipo = $request->input('type_option');
      $option->save();

      return response($option);
    }
  }

  public function update(Request $request) {
    if ($request->ajax()) {
      $option = Encuesta_pregunta_opcion::find($request->id);
      $option->indice = $request->input('index_option');
      $option->opcion = $request->input('name_option');
      $option->valor = $request->input('value_option');

      $option->update();
      return response($option);
    }
  }

  public function destroy(Request $request) {
    if ($request->ajax()) {
      Encuesta_pregunta_opcion::destroy($request->id);
    }
  }
}