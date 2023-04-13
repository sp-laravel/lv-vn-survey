<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario_docente extends Model {
  protected $guarded = [];
  use HasFactory;
  protected $connection = 'pgsql2';
  protected $table = 'horario_docentes';
}