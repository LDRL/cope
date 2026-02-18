<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Repositories\ProductoRepository;

class ProductoController extends Controller
{
    protected $productoRepo;

    public function __construct(ProductoRepository $productoRepo)
    {
        $this->productoRepo = $productoRepo;
    }

    // Para API JSON
    public function indexJson()
    {
        $productos = $this->productoRepo->all();
        return response()->json($productos);
    }

    // Para View Blade
    public function index()
    {
        $productos = $this->productoRepo->all();
        return view('catalogos.productos.index', compact('productos'));
    }
}
