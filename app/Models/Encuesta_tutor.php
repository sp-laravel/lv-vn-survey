<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta_tutor extends Model {
  use HasFactory;
  public $timestamps = false;
  protected $connection = 'pgsql2';
  protected $table = 'encuesta_tutores';
}