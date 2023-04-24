<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministradorController extends Controller {
  // public function show() {
  //   return view('admin.config');
  // }

  public function index() {
    $role = 'admin';
    return view('admin.index', compact('role'));
  }
}