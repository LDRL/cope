<?php

namespace App\Repositories;

use App\Models\CasaTipo;

class CasaTipoRepository
{
    public function all()
    {
        return CasaTipo::orderBy('nombre')->get();
    }
}
