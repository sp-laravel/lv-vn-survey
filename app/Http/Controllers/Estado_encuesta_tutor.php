<?php

namespace App\Http\Controllers;

use App\Models\Estado_encuesta_tutor as ModelsEstado_encuesta_tutor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Estado_encuesta_tutor extends Controller {
  public function update(Request $request) {
    // return $request->all();

    // Get Dates
    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $timeNow = $datetimeNow->toTimeString();

    // Validate Survey Status
    $status =  ModelsEstado_encuesta_tutor::where('aula', $request->aula)
      ->where('fecha', $dateNow)
      ->get();
    $statusQuantity =  count($status);

    if ($statusQuantity == 0) {
      $dataAll = array(
        'email_coordinador' => Auth::user()->email,
        "estado" => $request->status,
        "fecha" => $dateNow,
        "hora" => $timeNow,
        "dni_tutor" => $request->id,
        "aula" => $request->aula,
        "created_at" => $datetimeNow,
        "updated_at" => $datetimeNow
      );
      DB::connection('pgsql2')->table('estado_encuesta_tutores')->insert($dataAll);
    } else {
      DB::connection('pgsql2')->table('estado_encuesta_tutores')
        // ->where('email_coordinador', Auth::user()->email)
        ->where('dni_tutor', $request->id)
        ->where('aula', $request->aula)
        ->where('fecha', $dateNow)
        ->update(['estado' => $request->status, 'updated_at' => $datetimeNow, 'email_coordinador' => Auth::user()->email]);
    }

    return response()->json(array('msg' => $statusQuantity), 200);
  }
}