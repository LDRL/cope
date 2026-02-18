<?php

namespace App\Repositories;

use App\Models\Etnia;

class EtniaRepository
{
    public function all()
    {
        return Etnia::orderBy('nombre')->get();
    }
}
