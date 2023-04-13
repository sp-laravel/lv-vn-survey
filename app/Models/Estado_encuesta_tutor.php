<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado_encuesta_tutor extends Model {
  use HasFactory;
  protected $guarded = [];
  protected $connection = 'pgsql2';
  protected $table = 'estado_encuesta_tutores';
}