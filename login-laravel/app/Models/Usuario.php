<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $fillable = ['nombres', 'apellidos', 'dni', 'email', 'pass', 'codigo_recuperacion', 'fecha_expiracion'];
    public $timestamps = false;
}
