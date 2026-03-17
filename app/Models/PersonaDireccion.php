<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PersonaDireccion extends Model
{
    protected $table = 'persona_direccion';

    protected $fillable = [
        'direccion',
        'referencia',
        'id_persona',
        'id_tipo_direccion',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
}
