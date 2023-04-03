<?php

namespace App\Http\Controllers\Alumno\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlumnoLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller {
  public function create() {
    return view('alumno.auth.login');
  }

  public function store(AlumnoLoginRequest $request): RedirectResponse {
    $request->authenticate();
    $request->session()->regenerate();
    return redirect()->intended(RouteServiceProvider::ALUMNO_HOME);
  }

  public function destroy(Request $request): RedirectResponse {
    Auth::guard('alumno')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
  }
}