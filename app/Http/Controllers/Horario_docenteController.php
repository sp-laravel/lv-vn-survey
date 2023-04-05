<?php

namespace App\Http\Controllers;

use App\Models\Horario_docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Horario_docenteController extends Controller {
  public function update(Request $request) {
    $data = "ID: " . $request->id;
    // Horario_docente::where('id', $request->id)->update(['estado' => $request->status]);
    // $off = DB::connection('pgsql2')->select("UPDATE 
    //       horario_docentes
    //       SET estado = 0
    //     WHERE 
    //       id IN( " . $request->ids . ") 
    //   ");

    $on = DB::connection('pgsql2')->select("UPDATE 
          horario_docentes
          SET estado = " . $request->status . "
        WHERE 
          id = '" . $request->id . "'
      ");

    return response()->json(array('msg' => $data), 200);
  }
}