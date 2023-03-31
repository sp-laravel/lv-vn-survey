<?php

namespace App\Console\Commands;

use App\Http\Controllers\SheetController;
use Illuminate\Console\Command;

class SheetCommand extends Command {
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'sheet:replicate';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Replicate Data Fron Sheet to Postgres';

  /**
   * Execute the console command.
   */
  public function handle(): void {
    $data = (new SheetController())->index();
  }
}