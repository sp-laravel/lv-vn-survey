<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta_pregunta_opcion extends Model {
  use HasFactory;
  protected $connection = 'pgsql2';
  protected $fillable = ['indice', 'opcion', 'valor'];
  protected $table = 'encuesta_pregunta_opciones';
}