<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta_docente extends Model {
  use HasFactory;
  protected $connection = 'pgsql2';
}