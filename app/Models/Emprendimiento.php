<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Emprendimiento extends Model
{
    use HasFactory;

    protected $table = 'emprendimiento';

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'nombre',
        'giro_negocio',
        'id_actividad_economica',
        'fecha',
        'constituida_legalmente',
        'empleado_masculino',
        'empleado_femenino',
        'establecida_casa',
        'tiene_sucursales',
        'plataformas',
        'negocio_por_internet',
        'programa_rngg',
        'id_persona',
        'id_servicio_financiero'
    ];

    // Relaciones pivot
    public function aspectosFormalizacion()
    {
        return $this->belongsToMany(
            AspectoFormalizacion::class,
            'emprendimiento_formalizacion',
            'id_emprendimiento',
            'id_aspecto_formalizacion'
        );
    }

    public function redesSociales()
    {
        return $this->belongsToMany(
            RedesSociales::class,
            'emprendimiento_redes',
            'id_emprendimiento',
            'id_redes_sociales'
        );
    }
}