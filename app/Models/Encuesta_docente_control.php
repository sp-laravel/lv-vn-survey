<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta_docente_control extends Model {
  use HasFactory;
  protected $connection = 'pgsql2';
  protected $guarded = [];
  protected $table = 'encuesta_docente_controles';
}