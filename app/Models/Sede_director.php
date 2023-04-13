<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede_director extends Model {
  use HasFactory;
  protected $fillable = ['sede', 'email_director'];
  protected $connection = 'pgsql2';
  protected $table = 'sede_directores';
}