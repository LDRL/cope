<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Repositories\TipoServicioRepository;

class TipoServicioController extends Controller
{
    protected $tipoRepo;

    public function __construct(TipoServicioRepository $tipoRepo)
    {
        $this->tipoRepo = $tipoRepo;
    }

    // Para API JSON
    public function indexJson()
    {
        $tipoServicios = $this->tipoRepo->all();
        return response()->json($tipoServicios);
    }

    // Para View Blade
    public function index()
    {
        $tipoServicios = $this->tipoRepo->all();
        return view('catalogos.tipoServicios.index', compact('tipoServicios'));
    }
}
