<?php

namespace App\Repositories;

use App\Models\Producto;

class ProductoRepository
{
    public function all()
    {
        return Producto::orderBy('nombre')->get();
    }
}
