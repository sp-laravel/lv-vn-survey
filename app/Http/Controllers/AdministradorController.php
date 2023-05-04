<?php

namespace App\Http\Controllers;

use App\Models\Administrador;
use App\Models\Estado_encuesta_tutor;
use App\Models\Horario_docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    $tutors = [];
    $emailTemp = "";
    $apellidoTemp = "";
    $nombreTemp = "";

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

      $directors = Estado_encuesta_tutor::where('estado', 1)->get();
      $getTutors = Horario_docente::where('estado', 1)->get();
      // return $getTutors;

      foreach ($getTutors as $tutor) {
        // Get Tutor Info
        $cycles = DB::select("SELECT DISTINCT
            initcap(dus1.apellido_paterno||' '||dus1.apellido_materno)  as apellido_tutor,
            initcap(dus1.nombres) as nombre_tutor,
            us1.email as email_tutor,
            au.codigo_aula as codigo_final
          FROM alumno_matricula am
            INNER JOIN aulas au ON au.id = am.aula_id
            LEFT JOIN users us1 ON us1.id = au.tutor_id 
            LEFT JOIN personas dus1 ON dus1.dni = us1.persona_dni
          WHERE 
            am.estado IN(2,3) 
            AND am.estado_aula=1 
            AND au.codigo_aula <> ''
            AND au.codigo_aula IS NOT NULL
            AND au.codigo_aula = '" . $tutor->aula . "'  
        ");

        if (count($cycles) >= 1) {
          $emailTemp = $cycles[0]->email_tutor;
          $apellidoTemp = $cycles[0]->apellido_tutor;
          $nombreTemp = $cycles[0]->nombre_tutor;
        } else {
          $emailTemp = "";
          $apellidoTemp = "";
          $nombreTemp = "";
        }

        $tutorsTemp = [
          'aula' => $tutor->aula,
          'email_tutor' => $emailTemp,
          'apellido_tutor' => $apellidoTemp,
          'nombre_tutor' => $nombreTemp
        ];
        array_push($tutors, $tutorsTemp);
      }

      $tutorUsers =  DB::select("SELECT email,persona_dni
        FROM public.users tuse
          INNER JOIN model_has_roles tmrol ON tmrol.model_id = tuse.id
        WHERE tmrol.role_id = 11
        ORDER BY email 
      ");

      return view('admin.index', compact('role', 'configFull', 'directors', 'tutors', 'tutorUsers'));
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