<?php

namespace App\Repositories;

use App\Models\TipoServicio;

class TipoServicioRepository
{
    public function all()
    {
        return TipoServicio::orderBy('nombre')->get();
    }
}
