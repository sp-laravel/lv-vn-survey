<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('encuesta_docentes', function (Blueprint $table) {
      $table->id();
      $table->string('docente');
      $table->string('curso');
      $table->string('aula');
      $table->date('fecha');
      $table->time('hora');
      $table->integer('n1');
      $table->integer('n2');
      $table->integer('n3');
      $table->integer('n4');
      $table->string('dni_alumno');
      // $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('encuesta_docentes');
  }
};