<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Repositories\NacionalidadRepository;

class NacionalidadController extends Controller
{
    protected $nacionalidadRepo;

    public function __construct(NacionalidadRepository $nacionalidadRepo)
    {
        $this->nacionalidadRepo = $nacionalidadRepo;
    }

    // Para API JSON
    public function indexJson()
    {
        $nacionalidades = $this->nacionalidadRepo->all();
        return response()->json($nacionalidades);
    }

    // Para View Blade
    public function index()
    {
        $nacionalidades = $this->nacionalidadRepo->all();
        return view('catalogos.nacionalidades.index', compact('nacionalidades'));
    }
}
