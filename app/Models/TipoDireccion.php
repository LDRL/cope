<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDireccion extends Model
{
    protected $table = 'tipo_direccion';

    protected $fillable = ['nombre'];
}
