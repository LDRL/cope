<?php

namespace App\Repositories;

use App\Models\EstadoCivil;

class EstadoCivilRepository
{
    public function all()
    {
        return EstadoCivil::orderBy('nombre')->get();
    }
}
