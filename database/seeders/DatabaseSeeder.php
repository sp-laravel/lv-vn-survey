<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
  /**
   * Seed the application's database.
   */
  public function run(): void {
    $this->call(Sede_directorSeeder::class);
    $this->call(Encuesta_docenteSeeder::class);
    $this->call(Encuesta_tutorSeeder::class);
    $this->call(AdministradorSeeder::class);
    $this->call(Encuesta_opcionSeeder::class);
  }
}