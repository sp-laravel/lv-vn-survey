<?php

namespace App\Http\Controllers;

use App\Models\Sede_director;
use Illuminate\Http\Request;

class Sede_directorController extends Controller {
  public function index() {
    return view('welcome');
  }

  public function show() {
    $sedes = Sede_director::orderBy('id')->get();
    return view('sede.index', compact('sedes'));
  }

  public function store(Request $request) {
    if ($request->ajax()) {
      $sede = new Sede_director;
      $sede->sede = $request->input('sede');
      $sede->email_director = $request->input('email_director');
      $sede->save();

      return response($sede);
    }
  }

  public function update(Request $request) {
    if ($request->ajax()) {
      $sede = Sede_director::find($request->id);
      $sede->sede = $request->input('sede');
      $sede->email_director = $request->input('email_director');

      $sede->update();
      return response($sede);
    }
  }

  public function destroy(Request $request) {
    if ($request->ajax()) {
      Sede_director::destroy($request->id);
    }
  }
}