<?php

namespace App\Http\Controllers\Credito;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\CasaTipo;
use App\Models\ActividadEconomica;
use App\Models\RedesSociales;
use App\Models\AspectoFormalizacion;
use App\Models\ServicioFinanciero;
use App\Models\Persona;
use App\Models\Emprendimiento;

use App\Repositories\Contracts\PersonaRepositoryInterface;
use App\Repositories\OficinaRepository;
use App\Repositories\DestinoRepository;
use App\Repositories\TipoServicioRepository;
use App\Repositories\ProductoRepository;
use App\Repositories\NacionalidadRepository;
use App\Repositories\EstadoCivilRepository;
use App\Repositories\EtniaRepository;

use App\Services\Credito\SolicitudService;

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
    protected $actividadRepo;
    protected $redSocialReppo;
    protected $aspectoFormalizacionRepo;
    protected $personaRepo;
    protected $solicitudService;

    public function __construct(
        OficinaRepository $oficinaRepo,
        DestinoRepository $destinoRepo,
        TipoServicioRepository $tipoServicioRepo,
        ProductoRepository $productoRepo,
        NacionalidadRepository $nacionalidadRepo,
        EstadoCivilRepository $estadoCivilRepo,
        EtniaRepository $etniaRepo,
        CasaTipo $casaRepo,
        ActividadEconomica $actividadRepo,
        RedesSociales $redSocialReppo,
        AspectoFormalizacion $aspectoFormalizacionRepo,
        PersonaRepositoryInterface $personaRepo,
        SolicitudService $solicitudService
    ){
        $this->oficinaRepo = $oficinaRepo;
        $this->destinoRepo = $destinoRepo;
        $this->tipoServicioRepo = $tipoServicioRepo;
        $this->productoRepo = $productoRepo;
        $this->nacionalidadRepo = $nacionalidadRepo;
        $this->estadoCivilRepo = $estadoCivilRepo;
        $this->etniaRepo = $etniaRepo;
        $this->casaRepo = $casaRepo;
        $this->actividadRepo = $actividadRepo;
        $this->redSocialReppo = $redSocialReppo;
        $this->aspectoFormalizacionRepo = $aspectoFormalizacionRepo;
        $this->personaRepo = $personaRepo;
        $this->solicitudService = $solicitudService;
    }

    // =======================
    // LISTADO DE PERSONAS / SERVICIOS
    // =======================
    public function index()
    {
        $servicios = $this->personaRepo->getPersonasPaginated(10);
        return view('credito.index', compact('servicios'));
    }

    // =======================
    // PASO 1: Mostrar formulario de Servicio Financiero
    // =======================
    public function mostrarPaso1()
    {
        $servicio = null;
        if(session()->has('servicio_financiero_id')){
            $servicio = ServicioFinanciero::find(session('servicio_financiero_id'));
        }

        $oficinas = $this->oficinaRepo->all();
        $destinos = $this->destinoRepo->all();
        $tipoServicios = $this->tipoServicioRepo->all();
        $productos = $this->productoRepo->all();

        return view('credito.solicitudServicio', compact(
            'servicio', 'oficinas','destinos','tipoServicios','productos'
        ));
    }

    // PASO 1: Guardar Servicio Financiero
    public function paso1(Request $request)
    {
        $validated = $request->validate([
            'no_beneficiario' => 'required|string|max:100',
            'no_servicio' => 'required|string|max:100',
            'fecha_solicitud' => 'required|date',
            'oficina_id' => 'required',
            'monto' => 'required',
            'plazo' => 'required',
            'tasa' => 'required',
            'destino_id' => 'required',
            'periodo_gracia' => 'required|string',
            'tipo_servicio_id' => 'required',
            'producto_id' => 'required',
        ]);

        $validated['estado'] = "datos_generales";

        $servicio = $this->solicitudService->guardarServicio($validated, $request->id);

        return redirect()->route('solicitud-credito.datos-generales', $servicio->id);
    }

    // =======================
    // PASO 2: Mostrar formulario de Persona
    // =======================
    public function mostrarPaso2($id = null)
    {
        $servicio = ServicioFinanciero::find($id);
        $persona = Persona::find($servicio->persona_id ?? null);

        $nacionalidades = $this->nacionalidadRepo->all();
        $etnias = $this->etniaRepo->all();
        $estadoCivil = $this->estadoCivilRepo->all();
        $casaTipo = $this->casaRepo->all();

        $personaServicio = null;
        if($persona){
            $personaServicio = DB::table('persona_servicio')
                ->select('id')
                ->where('id_persona','=',$persona->id)
                ->where('id_tipo_persona','=',1)
                ->first();
        }

        return view('credito.solicitud', compact(
            'servicio', 'nacionalidades','etnias','estadoCivil','casaTipo','persona','personaServicio'
        ));
    }

    // PASO 2: Guardar Persona y vincular Servicio
    public function paso2(Request $request)
    {
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

        $persona = $this->solicitudService->guardarPersona($validated, $request->id);

        $this->solicitudService->vincularPersonaServicio(
            $persona->id,
            $request->servicio_id,
            $request->idPersonaServicio
        );

        return redirect()->route(
            'solicitud-credito.datos-emprendimiento',
            [$persona->id, $request->servicio_id]
        );
    }

    // =======================
    // PASO 3: Mostrar formulario de Emprendimiento
    // =======================
    public function mostrarPaso3($idPersona = null, $idServicio = null)
    {
        $emprendimiento = Emprendimiento::with(['aspectosFormalizacion','redesSociales'])
            ->where('id_persona',$idPersona)
            ->where('id_servicio_financiero',$idServicio)
            ->first();

        $actividadEconomicas = $this->actividadRepo->all();
        $redesSociales = $this->redSocialReppo->all();
        $aspectoFormalizaciones = $this->aspectoFormalizacionRepo->all();

        return view('credito.solicitudEmprendimiento', compact(
            'emprendimiento',
            'actividadEconomicas',
            'redesSociales',
            'aspectoFormalizaciones',
            'idPersona',
            'idServicio'
        ));
    }

    // PASO 3: Guardar Emprendimiento
    public function paso3(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'giro_negocio' => 'nullable|string|max:255',
            'id_actividad_economica' => 'required|exists:actividad_economica,id',
            'fecha' => 'required|date',
            'constituida_legalmente' => 'nullable|string',
            'empleado_masculino' => 'nullable|integer|min:0',
            'empleado_femenino' => 'nullable|integer|min:0',
            'establecida_casa' => 'nullable|string',
            'tiene_sucursales' => 'nullable|string',
            'plataformas' => 'nullable|string|max:255',
            'negocio_por_internet' => 'nullable|string',
            'programa_rngg' => 'nullable|string|max:255',
            'aspectos' => 'nullable|array',
            'aspectos.*' => 'integer|exists:aspecto_formalizacion,id',
            'redes' => 'nullable|array',
            'redes.*' => 'integer|exists:redes_sociales,id',
        ]);

        $this->solicitudService->guardarEmprendimiento($request);
    }
}