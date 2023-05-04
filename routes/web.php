<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DirectorController;
use App\Http\Controllers\Encuesta_docenteController;
use App\Http\Controllers\Encuesta_pregunta_opcionController;
use App\Http\Controllers\Encuesta_tutorController;
use App\Http\Controllers\EncuestaDocentePreguntaController;
use App\Http\Controllers\EncuestaTutorPreguntaController;
use App\Http\Controllers\Estado_encuesta_tutor;
use App\Http\Controllers\Horario_docenteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sede_directorController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// TEST
Route::get('/test', [TestController::class, 'index']);

// HOME
Route::get('/', WelcomeController::class)->middleware(['auth', 'verified'])->middleware(['auth', 'verified'])->name('welcome');

// SUPER ADMIN
Route::get('/dashboard', [AdministradorController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/sheet', [SheetController::class, 'index'])->name('sheet');
// Route::get('/test', [Horario_docenteController::class, 'activate'])->name('sheet');

// ACTIVE STATUS
Route::post('/horary', [Horario_docenteController::class, 'update'])->middleware(['auth', 'verified'])->name('horary');
Route::post('/survey', [Estado_encuesta_tutor::class, 'update'])->middleware(['auth', 'verified'])->name('survey');

// LIST TABLES
Route::get('/director_list', [DirectorController::class, 'show'])->middleware(['auth', 'verified']);
// Route::get('/tutor_list', [TutorController::class, 'show'])->middleware(['auth', 'verified']);
Route::get('/tutor_list/{dni}/{dashboard}', [TutorController::class, 'show'])->middleware(['auth', 'verified']);
Route::get('/tutor_surveyed/{aula}/{curso}/{docente}', [TutorController::class, 'surveyed'])->middleware(['auth', 'verified']);
Route::get('/alumn_form', [AlumnoController::class, 'show'])->middleware(['auth', 'verified']);

// ADMIN
Route::get('/admin_show', [AdministradorController::class, 'show'])->middleware(['auth', 'verified']);
Route::post('/admin_store', [AdministradorController::class, 'store'])->middleware(['auth', 'verified']);
Route::post('/admin_update', [AdministradorController::class, 'update'])->middleware(['auth', 'verified']);
Route::post('/admin_delete', [AdministradorController::class, 'destroy'])->middleware(['auth', 'verified']);

// SEDE
Route::get('/sede_show', [Sede_directorController::class, 'show'])->middleware(['auth', 'verified']);
Route::post('/sede_store', [Sede_directorController::class, 'store'])->middleware(['auth', 'verified']);
Route::post('/sede_update', [Sede_directorController::class, 'update'])->middleware(['auth', 'verified']);
Route::post('/sede_delete', [Sede_directorController::class, 'destroy'])->middleware(['auth', 'verified']);

// TEACHER QUESTIONS
Route::get('/teacher_show', [EncuestaDocentePreguntaController::class, 'show'])->middleware(['auth', 'verified']);
Route::post('/teacher_store', [EncuestaDocentePreguntaController::class, 'store'])->middleware(['auth', 'verified']);
Route::post('/teacher_update', [EncuestaDocentePreguntaController::class, 'update'])->middleware(['auth', 'verified']);
Route::post('/teacher_delete', [EncuestaDocentePreguntaController::class, 'destroy'])->middleware(['auth', 'verified']);

// TUTOR QUESTIONS
Route::get('/tutor_show', [EncuestaTutorPreguntaController::class, 'show'])->middleware(['auth', 'verified']);
Route::post('/tutor_store', [EncuestaTutorPreguntaController::class, 'store'])->middleware(['auth', 'verified']);
Route::post('/tutor_update', [EncuestaTutorPreguntaController::class, 'update'])->middleware(['auth', 'verified']);
Route::post('/tutor_delete', [EncuestaTutorPreguntaController::class, 'destroy'])->middleware(['auth', 'verified']);

// OPTION QUESTIONS
Route::get('/option_show/{type}', [Encuesta_pregunta_opcionController::class, 'show'])->middleware(['auth', 'verified']);
Route::post('/option_store', [Encuesta_pregunta_opcionController::class, 'store'])->middleware(['auth', 'verified']);
Route::post('/option_update', [Encuesta_pregunta_opcionController::class, 'update'])->middleware(['auth', 'verified']);
Route::post('/option_delete', [Encuesta_pregunta_opcionController::class, 'destroy'])->middleware(['auth', 'verified']);

// ENCUESTAS ADD
Route::post('encuesta_docente', [Encuesta_docenteController::class, 'store'])->middleware(['auth', 'verified'])->name('encuesta_docente.store');
Route::post('encuesta_tutor', [Encuesta_tutorController::class, 'store'])->middleware(['auth', 'verified'])->name('encuesta_tutor.store');

// API
Route::get('/survey_tutor/v1', [Encuesta_tutorController::class, 'index']);
Route::get('/survey_docente/v1', [Encuesta_docenteController::class, 'index']);

// Route::middleware('auth')->group(function () {
//   Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//   Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//   Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';