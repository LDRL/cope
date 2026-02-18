<?php

namespace App\Http\Controllers\Catalogo;

use App\Http\Controllers\Controller;
use App\Repositories\EtniaRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class EtniaController extends Controller
{
    protected $etniaRepo;

    public function __construct(EtniaRepository $etniaRepo)
    {
        $this->etniaRepo = $etniaRepo;
    }

    public function indexJson(): JsonResponse
    {
        $etnias = $this->etniaRepo->all();
        return response()->json($etnias);
    }

    // Para View Blade
    public function index()
    {
        $etnias = $this->etniaRepo->all();
        return view('catalogos.etnias.index', compact('etnias'));
    }
}
