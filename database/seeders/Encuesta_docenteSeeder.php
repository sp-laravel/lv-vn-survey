<?php

namespace Database\Seeders;

use App\Models\Encuesta_docente_pregunta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Encuesta_docenteSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    Encuesta_docente_pregunta::create([
      'numero_pregunta' => 1,
      'pregunta' => '¿El docente inició su clase puntualmente?'
    ]);
    Encuesta_docente_pregunta::create([
      'numero_pregunta' => 2,
      'pregunta' => '¿Entendiste la clase?'
    ]);
    Encuesta_docente_pregunta::create([
      'numero_pregunta' => 3,
      'pregunta' => '¿El docente desarrolló toda la teoría de la clase y/o cómo mínimo el 70% de las preguntas?'
    ]);
    Encuesta_docente_pregunta::create([
      'numero_pregunta' => 4,
      'pregunta' => '¿El docente es exigente en clase y se preocupa para que todos aprendan?'
    ]);
  }
}