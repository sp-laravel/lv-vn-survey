<?php

use App\Http\Controllers\Encuesta_docenteController;
use App\Http\Controllers\Encuesta_tutorController;
use App\Http\Controllers\EncuestaDocentePreguntaController;
use App\Http\Controllers\EncuestaTutorPreguntaController;
use App\Http\Controllers\Estado_encuesta_tutor;
use App\Http\Controllers\Horario_docenteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sede_directorController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//   return view('welcome');
// });

// Route::get('/', function () {
// return view('welcome');
// })->middleware(['auth', 'verified'])->name('welcome');

// Route::get('/dashboard', function () {
//   return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', [WelcomeController::class, 'index'])->middleware(['auth', 'verified'])->name('welcome');

Route::get('/sheet', [SheetController::class, 'index'])->name('sheet');
Route::post('/horary', [Horario_docenteController::class, 'update'])->name('horary');
Route::post('/survey', [Estado_encuesta_tutor::class, 'update'])->name('survey');

Route::get('/sede_show', [Sede_directorController::class, 'show'])->name('show');
Route::post('/sede_store', [Sede_directorController::class, 'store'])->name('store');
Route::post('/sede_update', [Sede_directorController::class, 'update'])->name('update');
Route::post('/sede_delete', [Sede_directorController::class, 'destroy'])->name('destroy');

Route::get('/teacher_show', [EncuestaDocentePreguntaController::class, 'show'])->name('show');
Route::post('/teacher_store', [EncuestaDocentePreguntaController::class, 'store'])->name('store');
Route::post('/teacher_update', [EncuestaDocentePreguntaController::class, 'update'])->name('update');
Route::post('/teacher_delete', [EncuestaDocentePreguntaController::class, 'destroy'])->name('destroy');

Route::get('/tutor_show', [EncuestaTutorPreguntaController::class, 'show'])->name('show');
Route::post('/tutor_store', [EncuestaTutorPreguntaController::class, 'store'])->name('store');
Route::post('/tutor_update', [EncuestaTutorPreguntaController::class, 'update'])->name('update');
Route::post('/tutor_delete', [EncuestaTutorPreguntaController::class, 'destroy'])->name('destroy');

Route::post('encuesta_docente', [Encuesta_docenteController::class, 'store'])->name('encuesta_docente.store');
Route::post('encuesta_tutor', [Encuesta_tutorController::class, 'store'])->name('encuesta_tutor.store');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';