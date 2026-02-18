<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioFinanciero extends Model
{
    protected $table = 'servicio_financiero';

    protected $fillable = [
        'no_beneficiario',
        'no_servicio',
        'fecha_solicitud',
        'oficina_id',
        'monto',
        'destino_id',
        'periodo_gracia',
        'tipo_servicio_id',
        'producto_id',
        'estado',
        'pesona_id'
    ];

    //Relacion con personas
    public function personas()
    {
        return $this->belongsToMany(
            Persona::class,
            'persona_servicio',
            'servicio_financiero_id',
            'persona_id'
        )->withTimestamps();
    }
}
