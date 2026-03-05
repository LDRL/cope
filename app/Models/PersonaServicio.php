<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaServicio extends Model
{
    protected $table = 'persona_servicio';

    protected $fillable = [
        'id_persona',
        'id_servicio_financiero',
        'id_tipo_persona'
    ];

    public function servicioFinanciero()
    {
        return $this->belongsTo(ServicioFinanciero::class, 'id_servicio_financiero');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
}
