<?php

namespace App\Console;

use App\Http\Controllers\SheetController;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {
  /**
   * Define the application's command schedule.
   */
  protected function schedule(Schedule $schedule): void {
    $schedule->command('teacher:control')->dailyAt('22:00');
    $schedule->command('sheet:replicate')->dailyAt('23:50');
    $schedule->command('horary:observer')->everyMinute();
    $schedule->command('test:show')->everyMinute();

    // $schedule->command('inspire')->hourly();
    // $schedule->command('sheet:replicate')->everyMinute();
    // $schedule->call(function () {
    //   $data = (new SheetController())->index();
    // })->everyMinute();
  }

  /**
   * Register the commands for the application.
   */
  protected function commands(): void {
    $this->load(__DIR__ . '/Commands');

    require base_path('routes/console.php');
  }
}