<?php

namespace App\Http\Controllers\Credito;

use App\Http\Controllers\Controller;
use App\Models\CasaTipo;
use App\Models\Persona;
use App\Models\ServicioFinanciero;
use App\Repositories\DestinoRepository;
use App\Repositories\EstadoCivilRepository;
use App\Repositories\EtniaRepository;
use App\Repositories\NacionalidadRepository;
use Illuminate\Http\Request;

use App\Repositories\OficinaRepository;
use App\Repositories\ProductoRepository;
use App\Repositories\TipoServicioRepository;

use Carbon\Carbon;

class SolicitudController extends Controller
{
    

    protected $oficinaRepo;
    protected $destinoRepo;
    protected $tipoServicioRepo;
    protected $productoRepo;
    protected $nacionalidadRepo;
    protected $estadoCivilRepo;
    protected $etniaRepo;
    protected $casaRepo;

    public function __construct(OficinaRepository $oficinaRepo, DestinoRepository $destinoRepo, TipoServicioRepository $tipoServicioRepo,
    ProductoRepository $productoRepo,
    NacionalidadRepository $nacionalidadRepo,
    EstadoCivilRepository $estadoCivilRepo,
    EtniaRepository $etniaRepo,
    CasaTipo $casaRepo)
    {
        $this->oficinaRepo = $oficinaRepo;
        $this->destinoRepo = $destinoRepo;
        $this->tipoServicioRepo = $tipoServicioRepo;
        $this->productoRepo = $productoRepo;
        $this->nacionalidadRepo = $nacionalidadRepo;
        $this->estadoCivilRepo = $estadoCivilRepo;
        $this->etniaRepo = $etniaRepo;
        $this->casaRepo = $casaRepo;
    }

    // PASO 1: Crear o actualizar persona
    public function mostrarPaso1()
    {
        $servicio = null;
        // Si ya existe persona_id en session, cargar datos de la DB
        if(session()->has('servicio_financiero_id')){
            //$persona = Persona::find(session('persona_id'));
            $servicio = ServicioFinanciero::find(session('servicio_financiero_id'));
        }

        $oficinas = $this->oficinaRepo->all();
        $destinos = $this->destinoRepo->all();
        $tipoServicios = $this->tipoServicioRepo->all();
        $productos = $this->productoRepo->all();

        // Retornar la vista del paso 1 con los datos (puede ser null si es nuevo)
        return view('credito.solicitudServicio', compact('servicio', 'oficinas','destinos', 'tipoServicios', 'productos'));
    }

    public function paso1(Request $request)
    {
        $id = $request->id;
        
        $validated = $request->validate([
            'no_beneficiario' => 'required|string|max:100',
            'no_servicio' => 'required|string|max:100',
            'fecha_solicitud' => 'required|date',
            'oficina_id' => 'required',
            'monto' => 'required',
            'plazo' => 'required',
            'tasa' => 'required',
            'destino_id' => 'required',
            'periodo_gracia' => 'required|string|',
            'tipo_servicio_id' => 'required',
            'producto_id' => 'required',
            // otros campos...
        ]);

        $validated['estado'] = "datos_generales";

        if($id){
            $servicio = ServicioFinanciero::findOrFail($id);
            $servicio->update($validated);
        }else{
            $servicio = ServicioFinanciero::create($validated);
        }

        return redirect()->route('solicitud-credito.datos-generales', $servicio->id);
    }

    public function mostrarPaso2($id = null){
        $servicio = ServicioFinanciero::find($id);
       

        $persona = Persona::find($servicio->persona_id);

        $nacionalidades = $this->nacionalidadRepo->all();
        $etnias = $this->etniaRepo->all();
        $estadoCivil = $this->estadoCivilRepo->all();
        $casaTipo = $this->casaRepo->all();

        return view('credito.solicitud', compact('servicio', 'nacionalidades', 'etnias','estadoCivil','casaTipo', 'persona'));
    }
    // PASO 2: Servicio financiero
    public function paso2(Request $request)
    {
        $id = $request->id;

        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required',
            'lugar_nacimiento' => 'required',
            'nacionalidad_id' => 'required',
            'etnia_id' => 'required',
            'estado_civil_id' => 'required',
            'numero_dpi' => 'required|string|max:13',
            'profesion_oficio' => 'required',
            'ocupacion_actual' => 'required',
            'celular' => 'required|digits:8',
            'numero_telefonico_casa' => 'nullable|digits:8',
            'numero_telefonico_otro' => 'nullable|digits:8',
            'direccion_domiciliar' => 'required',
            'referencia_de_direccion' => 'required',
            'tiempo_residencia' => 'required',
            'casa_tipo_id' => 'required'
        ]);

        if($id){
            $persona = Persona::findOrFail($id);
            $persona->update($validated);
        }else{
            $persona = Persona::create($validated);
        }

        $servicio_Id = $request->servicio_id;
        $servicio = ServicioFinanciero::findOrFail($servicio_Id);
        $servicio->persona_id = $persona->id;
        $servicio->estado = "datos_emprendimiento";
        $servicio->save();

        return redirect()->route('solicitud-credito.datos-emprendimiento', $persona->id);
    }

    public function mostrarPaso3($id = null){
        $persona = Persona::find($id);
        return view('credito.solicitudEmprendimiento', compact('persona'));
    }


    // PASO 3: Datos de emprendimiento
    public function paso3(Request $request)
    {
        
    }
}
