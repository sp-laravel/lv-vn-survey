<?php

namespace App\Http\Controllers;

use App\Models\Horario_docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Horario_docenteController extends Controller {
  public function update(Request $request) {
    // $data = "ID: " . $request->id . " STATUS: " . $request->status;

    // $update = Horario_docente::where('id', $request->id)->update(['estado' => $request->status]);
    // if ($update) {
    //   return response()->json([
    //     'msg' => 200
    //   ]);
    // }

    // $off = DB::connection('pgsql2')->select("UPDATE 
    //       horario_docentes
    //       SET estado = 0
    //     WHERE 
    //       id IN( " . $request->ids . ") 
    //   ");

    // $sql5 = "UPDATE 
    //       horario_docentes
    //       SET estado = " . $request->status . "
    //     WHERE 
    //       id = " . $request->id . "
    //   ";
    // $result2 = DB::statement($sql5);

    // $on = DB::connection('pgsql2')->select("UPDATE 
    //       horario_docentes
    //       SET estado = " . $request->status . "
    //     WHERE 
    //       id = " . $request->id . "
    //   ");

    DB::connection('pgsql2')
      ->table('horario_docentes')
      ->where('id', $request->id)
      ->update(['estado' => $request->status]);

    $response =  DB::connection('pgsql2')->table('horario_docentes')
      ->where('id', $request->id)
      ->get();
    $responseStatus = $response[0]->estado;

    return response()->json(array('msg' => $responseStatus), 200);
  }
}