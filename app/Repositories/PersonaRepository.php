<?php

namespace App\Repositories;

use App\Models\Persona;
use App\Repositories\Contracts\PersonaRepositoryInterface;

class PersonaRepository implements PersonaRepositoryInterface
{

    public function getPersonasPaginated($perPage = 10)
    {
        return Persona::with('personaServicio.servicioFinanciero')
                ->orderBy('id','desc')
                ->paginate($perPage);
    }

}