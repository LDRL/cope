<?php

namespace App\Repositories;

use App\Models\RedesSociales;

class RedesSocialesRepository
{
    public function all()
    {
        return RedesSociales::orderBy('id')->get();
    }
}
