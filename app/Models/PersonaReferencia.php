<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaReferencia extends Model
{
    protected $table = 'persona_referencia';

    protected $fillable = [
        'nombre',
        'apellido',
        'numero_telefono',
        'tipo_relacion',
        'id_persona',
        'id_tipo_referencia'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }

    public function tipoReferencia()
    {
        return $this->belongsTo(TipoReferencia::class, 'id_tipo_referencia');
    }
}
