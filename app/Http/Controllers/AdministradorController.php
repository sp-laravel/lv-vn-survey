<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministradorController extends Controller {
  // public function show() {
  //   return view('admin.config');
  // }

  public function index() {
    $superAdmins = Administrador::SUPERADMINS;
    $admins = Administrador::orderBy('id')->get();
    $email = Auth::user()->email;
    $configFull = false;
    $config = false;
    $role = 'admin';
    $lisTAdmins = [];

    // Get list of admins
    foreach ($admins as $admin) {
      array_push($lisTAdmins, $admin->email);
    }

    // Validate Access Admin Full
    if (in_array($email, $superAdmins)) {
      $configFull = true;
    }

    // Validate Access Admin
    if (in_array($email, $lisTAdmins) || in_array($email, $superAdmins)) {
      $config = true;
    }

    // Validate View Admin
    if ($config) {
      return view('admin.index', compact('role', 'configFull'));
    } else {
      // return back()->with('message', ['No eres Admin']);
      return redirect()->route('welcome');
    }
  }

  public function show() {
    $admins = Administrador::orderBy('id')->get();
    return view('admin.list', compact('admins'));
  }

  public function store(Request $request) {
    if ($request->ajax()) {
      $admin = new Administrador;
      $admin->email = $request->input('email');
      $admin->save();

      return response($admin);
    }
  }

  public function update(Request $request) {
    if ($request->ajax()) {
      $admin = Administrador::find($request->id);
      $admin->email = $request->input('email');

      $admin->update();
      return response($admin);
    }
  }

  public function destroy(Request $request) {
    if ($request->ajax()) {
      Administrador::destroy($request->id);
    }
  }
}