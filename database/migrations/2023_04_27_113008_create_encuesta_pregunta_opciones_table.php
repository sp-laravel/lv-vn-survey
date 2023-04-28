<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('encuesta_pregunta_opciones', function (Blueprint $table) {
      $table->id();
      $table->integer('indice');
      $table->string('opcion', 100);
      $table->integer('valor');
      $table->string('tipo', 50);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('encuesta_pregunta_opciones');
  }
};