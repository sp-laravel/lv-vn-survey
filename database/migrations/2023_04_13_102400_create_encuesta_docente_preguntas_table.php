<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('encuesta_docente_preguntas', function (Blueprint $table) {
      $table->id();
      $table->integer('numero_pregunta');
      $table->text('pregunta');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('encuesta_docente_preguntas');
  }
};