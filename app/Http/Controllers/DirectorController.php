<?php

namespace App\Http\Controllers;

use App\Models\Sede_director;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectorController extends Controller {

  public function show() {
    // Data
    $name = Auth::user()->name;
    $email = Auth::user()->email;
    $dni = Auth::user()->persona_dni;
    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $sedeMerge = [];

    // Data
    $query = "";
    $sede = Sede_director::where('email_director', $email)->get();

    // Validate Director/Sede
    foreach ($sede as $sed) {
      array_push($sedeMerge, $sed->sede);
    }
    $query = "'" . implode("','", $sedeMerge) . "'";

    // Get cycles by Director
    $cycles = DB::select("SELECT DISTINCT
              dus1.dni as dni_tutor,
              us1.email as email_tutor,
              initcap(dus1.apellido_paterno||' '||dus1.apellido_materno)  as apellido_tutor,
              initcap(dus1.nombres) as nombre_tutor,
              au.codigo_aula as codigo_final,
              lo.nombre as sede,
              concat_ws('',0) AS estado
            FROM alumno_matricula am
              INNER JOIN aulas au ON au.id = am.aula_id
              LEFT JOIN users us1 ON us1.id = au.tutor_id 
              LEFT JOIN personas dus1 ON dus1.dni = us1.persona_dni
              INNER JOIN matriculas ma ON ma.id=au.matricula_id
              INNER JOIN locales lo ON lo.id = ma.local_id
            WHERE 
              am.estado IN(2,3,9) 
              AND am.estado_aula=1 
              AND au.codigo_aula <> ''
              AND au.codigo_aula IS NOT NULL 
              AND us1.email IS NOT NULL 
              AND  lo.nombre IN(" . $query . " )
            ORDER BY apellido_tutor
          ");

    // Get Status by Tutor
    $tutorStatus =  DB::connection('pgsql2')->table('estado_encuesta_tutores')
      ->where('email_coordinador', Auth::user()->email)
      ->where('fecha', $dateNow)
      ->get();

    // Get Cycle Active Tutor
    foreach ($cycles as $cycle) {
      foreach ($tutorStatus as $tutorStatu) {
        if ($cycle->codigo_final == $tutorStatu->aula && $tutorStatu->estado == 1) {
          $cycle->estado = 1;
        }
      }
    }
    return view('director.list', compact('cycles'));
  }
}