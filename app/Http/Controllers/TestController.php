<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller {
  public function index() {
    $admin = Administrador::all();
    return $admin;
  }
  public function update() {
    $datetimeNow = Carbon::now();
    $dateNow = $datetimeNow->toDateString();
    $timeNow = $datetimeNow->toTimeString();

    $admin = Administrador::find('1');
    $admin->email = 'hencisos@vonex.edu.pe' . " - " . $timeNow;
    $admin->update();
  }
}