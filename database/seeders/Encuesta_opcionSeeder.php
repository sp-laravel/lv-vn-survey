<?php

namespace Database\Seeders;

use App\Models\Encuesta_pregunta_opcion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Encuesta_opcionSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    Encuesta_pregunta_opcion::create([
      'indice' => 1,
      'opcion' => 'Nunca',
      'valor' => 5,
      'tipo' => 'docente',
    ]);
    Encuesta_pregunta_opcion::create([
      'indice' => 2,
      'opcion' => 'Pocas veces',
      'valor' => 10,
      'tipo' => 'docente',
    ]);
    Encuesta_pregunta_opcion::create([
      'indice' => 3,
      'opcion' => 'Casi siempre',
      'valor' => 15,
      'tipo' => 'docente',
    ]);
    Encuesta_pregunta_opcion::create([
      'indice' => 4,
      'opcion' => 'Siempre',
      'valor' => 20,
      'tipo' => 'docente',
    ]);

    Encuesta_pregunta_opcion::create([
      'indice' => 1,
      'opcion' => '1',
      'valor' => 1,
      'tipo' => 'tutor',
    ]);
    Encuesta_pregunta_opcion::create([
      'indice' => 2,
      'opcion' => '2',
      'valor' => 2,
      'tipo' => 'tutor',
    ]);
    Encuesta_pregunta_opcion::create([
      'indice' => 3,
      'opcion' => '3',
      'valor' => 3,
      'tipo' => 'tutor',
    ]);
    Encuesta_pregunta_opcion::create([
      'indice' => 4,
      'opcion' => '4',
      'valor' => 4,
      'tipo' => 'tutor',
    ]);
    Encuesta_pregunta_opcion::create([
      'indice' => 5,
      'opcion' => '5',
      'valor' => 5,
      'tipo' => 'tutor',
    ]);
  }
}