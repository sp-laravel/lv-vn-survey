<?php

namespace Database\Seeders;

use App\Models\Sede_director;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Sede_directorSeeder extends Seeder {
  /**
   * Run the database seeds.
   */
  public function run(): void {
    Sede_director::create([
      'sede' => 'LIMA CERCADO',
      'email_director' => 'henciso@vonex.edu.pe'
    ]);
    Sede_director::create([
      'sede' => 'LIMA SJL',
      'email_director' => 'apineda@vonex.edu.pe'
    ]);
    Sede_director::create([
      'sede' => 'LIMA NORTE',
      'email_director' => 'ybenito@vonex.edu.pe'
    ]);
    Sede_director::create([
      'sede' => 'HCO - DOS DE MAYO',
      'email_director' => 'afigueroa@vonex.edu.pe'
    ]);
    Sede_director::create([
      'sede' => 'HCO - CRESPO Y CASTILLO',
      'email_director' => 'afigueroa@vonex.edu.pe'
    ]);
  }
}