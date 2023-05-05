<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('encuesta_docente_controles', function (Blueprint $table) {
      $table->id();
      $table->date('fecha');
      $table->string('tutor', 200);
      $table->string('ciclo', 20);
      $table->string('docente', 200);
      $table->string('curso', 200);
      $table->integer('estado');
      $table->integer('total_encuestados');
      $table->integer('total_alumnos');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('encuesta_docente_controles');
  }
};