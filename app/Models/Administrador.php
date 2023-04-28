<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model {
  use HasFactory;
  protected $connection = 'pgsql2';
  protected $fillable = ['email'];
  protected $table = 'administradores';

  public const TIMESURVEYSTART = -169;
  public const TIMESURVEYEND = 1;
  public const SUPERADMINS = ["jcuadros@vonex.edu.pe", "soporte@vonex.edu.pe"];
}