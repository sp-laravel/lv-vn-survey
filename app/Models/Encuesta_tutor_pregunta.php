<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta_tutor_pregunta extends Model {
  use HasFactory;
  protected $connection = 'pgsql2';
  protected $fillable = ['numero_pregunta', 'pregunta'];
  protected $table = 'encuesta_tutor_preguntas';
}