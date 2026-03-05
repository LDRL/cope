<?php

namespace App\Repositories;

use App\Models\ActividadEconomica;

class CasaTipoRepository
{
    public function all()
    {
        return ActividadEconomica::orderBy('nombre')->get();
    }
}
