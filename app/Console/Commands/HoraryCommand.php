<?php

namespace App\Console\Commands;

use App\Http\Controllers\Horario_docenteController;
use Illuminate\Console\Command;

class HoraryCommand extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'horary:observer';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Active Survey Teachers Selected';

  /**
   * Execute the console command.
   */
  public function handle(): void {
    $data = (new Horario_docenteController())->activate();
  }
}