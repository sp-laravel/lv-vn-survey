<?php

namespace Database\Seeders;

use App\Models\Encuesta_tutor_pregunta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Encuesta_tutorSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    Encuesta_tutor_pregunta::create([
      'numero_pregunta' => 1,
      'pregunta' => '¿El tutor gestiona que la clase inicie puntualmente?'
    ]);
    Encuesta_tutor_pregunta::create([
      'numero_pregunta' => 2,
      'pregunta' => '¿El tutor está atento al desarrollo de la clase y apoya cuando se le requiere?'
    ]);
    Encuesta_tutor_pregunta::create([
      'numero_pregunta' => 3,
      'pregunta' => '¿El tutor te asesora y orienta oportunamente sobre las dudas o inconvenientes que presentas?'
    ]);
    Encuesta_tutor_pregunta::create([
      'numero_pregunta' => 4,
      'pregunta' => '¿Tiene actualizado el drive para que puedas complementar tu estudio desde casa?'
    ]);
    Encuesta_tutor_pregunta::create([
      'numero_pregunta' => 5,
      'pregunta' => '¿EL tutor hace uso del quizizz al finalizar las clases?'
    ]);
    Encuesta_tutor_pregunta::create([
      'numero_pregunta' => 6,
      'pregunta' => '¿El tutor te motiva al iniciar el día ?'
    ]);
    Encuesta_tutor_pregunta::create([
      'numero_pregunta' => 7,
      'pregunta' => '¿Tú tutor ha conversado contigo y/o apoderado por celular, WhatsApp o personalmente?'
    ]);
    Encuesta_tutor_pregunta::create([
      'numero_pregunta' => 8,
      'pregunta' => '¿Las charlas que realiza tu tutor te ayudan a mejorar tu desempeño académico?'
    ]);
  }
}