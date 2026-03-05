<?php

namespace App\Repositories;

use App\Models\AspectoFormalizacion;

class AspectoFormalizacionRepository
{
    public function all()
    {
        return AspectoFormalizacion::orderBy('id')->get();
    }
}
