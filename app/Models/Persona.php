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
        'id_nacionalidad',
        'id_etnia',
        'id_estado_civil',
        'numero_dpi',
        'profesion_oficio',
        'ocupacion_actual',
        'no_dependientes',
        'porcentaje_de_aporte_familiar',
        'tiempo_residencia',
        'id_casa_tipo',
        'lugar_trabajo',
        'nombre_cargo',
        'ingreso_neto'
       
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
            'id_persona',       // clave foránea de esta tabla
            'id_servicio_financiero' // clave foránea del otro modelo
        )->withTimestamps(); // si quieres usar created_at/updated_at
    }

    //
    public function personaServicio()
    {
        return $this->hasOne(PersonaServicio::class, 'id_persona');
    }

    // Relacion con persona telefono
    public function tipoTelefono()
    {
        return $this->belongsToMany(
            TipoTelefono::class,
            'persona_telefono',
            'id_persona',
            'id_tipo_telefono'
        )->withTimestamps();
    }

    public function telefonos()
    {
        return $this->hasMany(PersonaTelefono::class, 'id_persona');
    }

    public function direcciones()
    {
        return $this->hasMany(PersonaDireccion::class, 'id_persona');
    }
}
