<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('horario_docentes', function (Blueprint $table) {
      $table->id();
      $table->string('dia');
      $table->string('aula')->nullable();
      $table->string('docente')->nullable();
      $table->string('asignatura')->nullable();
      $table->time('h_inicio')->nullable();
      $table->time('h_fin')->nullable();
      $table->integer('estado')->nullable();
      // $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('horario_docentes');
  }
};