<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SheetDB\SheetDB;

class SheetController extends Controller {
  public function index() {
    $sheetdb = new SheetDB('3qepkvcneqzo8');
    $sheets = $sheetdb->get();
    $rows = count($sheets);
    // return $sheets;

    if ($rows >= 1) {
      $table = "horaries";
      $index = 0;
      DB::table($table)->delete();

      foreach ($sheets as $sheet) {
        $index++;
        $day = $sheet->DIA;
        $cycle = $sheet->CLASE;
        $teacher = $sheet->DOCENTE;
        $class = $sheet->ASIGNATURA;
        $start = $sheet->HORA_INICIO;
        $end = $sheet->HORA_FIN;

        // array_push($data, [$index, $day, $cycle, $teacher, $class, $start, $end]);
        $dataAll = array('id' => $index, "dia" => $day, "aula" => $cycle, "docente" => $teacher, "asignatura" => $class, "h_inicio" => $start, "h_fin" => $end);
        DB::table($table)->insert($dataAll);
        $dataAll = [];
      }

      // $dataOne = array('id' => $data[0][0], "dia" => $data[0][1], "aula" => $data[0][2], "docente" => $data[0][3], "asignatura" => $data[0][4], "h_inicio" => $data[0][5], "h_fin" => $data[0][6]);
      // DB::table('horarios')->insert($dataOne);
      return $sheets;
    }

    return $rows;
  }
}