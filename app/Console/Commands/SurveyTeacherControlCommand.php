<?php

namespace App\Console\Commands;

use App\Http\Controllers\EncuestaDocenteControlController;
use Illuminate\Console\Command;

class SurveyTeacherControlCommand extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'teacher:control';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Teacher Survey Control';

  /**
   * Execute the console command.
   */
  public function handle(): void {
    $data = (new EncuestaDocenteControlController())->store();
  }
}