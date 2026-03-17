<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaTelefono extends Model
{
    protected $table = 'persona_telefono';

    protected $fillable = [
        'numero',
        'id_persona',
        'id_tipo_telefono'
    ];

    public function TipoTelefono()
    {
        return $this->belongsTo(TipoTelefono::class, 'id_tipo_telefono');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
}
