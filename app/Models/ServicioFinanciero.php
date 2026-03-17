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
        'id_oficina',
        'monto',
        'id_destino',
        'periodo_gracia',
        'id_tipo_servicio',
        'id_producto',
        'plazo',
        'tasa',
        'estado'
    ];

    //Relacion con personas
    public function personas()
    {
        return $this->belongsToMany(
            Persona::class,
            'persona_servicio',
            'id_servicio_financiero',
            'id_persona'
        )->withTimestamps();
    }
}
