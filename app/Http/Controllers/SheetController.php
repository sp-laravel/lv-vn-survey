<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SheetDB\SheetDB;

class SheetController extends Controller {
  public function index() {
    $sheetdb = new SheetDB(config('services.sheetdb.key'));
    $sheets = $sheetdb->get();
    $rows = count($sheets);

    // Validate Quantity rows
    if ($rows >= 1) {
      $table = "horario_docentes";
      $index = 0;
      DB::connection('pgsql2')->table($table)->delete();

      foreach ($sheets as $sheet) {
        $index++;
        $day = $sheet->DIA;
        $cycle = $sheet->CLASE;
        $teacher = $sheet->DOCENTE;
        $class = $sheet->ASIGNATURA;
        $start = $sheet->HORA_INICIO;
        $end = $sheet->HORA_FIN;

        $dataAll = array('id' => $index, "dia" => $day, "aula" => $cycle, "docente" => $teacher, "asignatura" => $class, "h_inicio" => $start, "h_fin" => $end);
        DB::connection('pgsql2')->table($table)->insert($dataAll);
        $dataAll = [];
      }
      return $sheets;
    }

    return $rows;
  }
}