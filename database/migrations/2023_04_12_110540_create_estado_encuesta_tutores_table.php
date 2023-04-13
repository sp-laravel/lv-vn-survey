<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void {
    Schema::create('estado_encuesta_tutores', function (Blueprint $table) {
      $table->id();
      $table->string('email_coordinador');
      $table->integer('estado');
      $table->date('fecha');
      $table->time('hora');
      $table->string('dni_tutor');
      $table->string('aula');
      // $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('estado_encuesta_tutores');
  }
};