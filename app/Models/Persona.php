<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'sexo',
        'edad',
        'lugar_nacimiento',
        'nacionalidad_id',
        'etnia_id',
        'estado_civil_id',
        'numero_dpi',
        'profesion_oficio',
        'ocupacion_actual',
        'no_dependientes',
        'porcentaje_de_aporte_familiar',
        'celular',
        'numero_telefonico_casa',
        'numero_telefonico_otro',
        'direccion_domiciliar',
        'referencia_de_direccion',
        'tiempo_residencia',
        'casa_tipo_id'
    ];

    // Relaciones
    public function nacionalidad()
    {
        return $this->belongsTo(Nacionalidad::class);
    }

    public function etnia()
    {
        return $this->belongsTo(Etnia::class);
    }

    public function estadoCivil()
    {
        return $this->belongsTo(EstadoCivil::class);
    }

    //Relacion con servicio financieros
    public function servicios()
    {
        return $this->belongsToMany(
            ServicioFinanciero::class,
            'persona_servicio', // nombre de la tabla pivote
            'persona_id',       // clave foránea de esta tabla
            'servicio_financiero_id' // clave foránea del otro modelo
        )->withTimestamps(); // si quieres usar created_at/updated_at
    }
}
