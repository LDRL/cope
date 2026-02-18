<?php

namespace App\Repositories;

use App\Models\Nacionalidad;

class NacionalidadRepository
{
    public function all()
    {
        return Nacionalidad::orderBy('nombre')->get();
    }
}