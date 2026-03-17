<?php

namespace App\Repositories;

use App\Models\TipoReferencia;

class TipoReferenciaRepository
{
    public function all()
    {
        return TipoReferencia::orderBy('id')->get();
    }
}
