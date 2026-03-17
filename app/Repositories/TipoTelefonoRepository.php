<?php

namespace App\Repositories;

use App\Models\TipoTelefono;

class TipoTelefonoRepository
{
    public function all()
    {
        return TipoTelefono::orderBy('id')->get();
    }
}
