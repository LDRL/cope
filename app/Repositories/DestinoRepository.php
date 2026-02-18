<?php

namespace App\Repositories;

use App\Models\Destino;

class DestinoRepository
{
    public function all()
    {
        return Destino::orderBy('nombre')->get();
    }
}
