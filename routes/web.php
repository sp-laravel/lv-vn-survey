<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//   return view('welcome');
// });

// Route::get('/', function () {
// return view('welcome');
// })->middleware(['auth', 'verified'])->name('welcome');

Route::get('/', [WelcomeController::class, 'index'])->middleware(['auth', 'verified'])->name('welcome');

Route::get('/sheet', [SheetController::class, 'index'])->name('sheet');

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';