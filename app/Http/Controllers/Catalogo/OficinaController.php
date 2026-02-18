<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Repositories\OficinaRepository;

class OficinaController extends Controller
{
    protected $oficinaRepo;

    public function __construct(OficinaRepository $oficinaRepo)
    {
        $this->oficinaRepo = $oficinaRepo;
    }

    // Para API JSON
    public function indexJson()
    {
        $oficinas = $this->oficinaRepo->all();
        return response()->json($oficinas);
    }

    // Para View Blade
    public function index()
    {
        $oficinas = $this->oficinaRepo->all();
        return view('catalogos.oficinas.index', compact('oficinas'));
    }
}
