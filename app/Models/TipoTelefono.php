<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoTelefono extends Model
{
    protected $table = 'tipo_telefono';

    protected $fillable = ['nombre'];

    //Relacion con personas
    public function personas()
    {
        return $this->belongsToMany(
            Persona::class,
            'persona_telefono',
            'id_tipo_telefono',
            'id_persona'
        )->withTimestamps();
    }
}
