<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Repositories\EstadoCivilRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EstadoCivilController extends Controller
{
    protected $estadoCivilRepo;

    public function __construct(EstadoCivilRepository $estadoCivilRepo)
    {
        $this->estadoCivilRepo = $estadoCivilRepo;
    }

    public function indexJson(): JsonResponse
    {
        $estados = $this->estadoCivilRepo->all();
        return response()->json($estados);
    }

    public function index()
    {
        $estados = $this->estadoCivilRepo->all();
        return view('catalogos.estado_civil.index', compact('estdo-civil'));
    }
}
