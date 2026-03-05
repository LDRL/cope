<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPersona extends Model
{
    protected $table = 'tipo_persona';

    protected $fillable = ['nombre'];
}
