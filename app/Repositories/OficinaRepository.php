<?php

namespace App\Repositories;

use App\Models\Oficina;

class OficinaRepository
{
    public function all()
    {
        return Oficina::orderBy('nombre')->get();
    }
}
