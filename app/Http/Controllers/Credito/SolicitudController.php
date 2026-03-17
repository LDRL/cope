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
use App\Repositories\TipoTelefonoRepository;

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
    protected $tipoTelefonoRepo;

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
        SolicitudService $solicitudService,
        TipoTelefonoRepository $tipoTelefonoRepo
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
        $this->tipoTelefonoRepo = $tipoTelefonoRepo;
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
    // PASO 1: Mostrar formulario de Persona
    // =======================
    public function mostrarPaso1($id = null)
    {
        //$servicio = ServicioFinanciero::find($id);
        $persona = Persona::find($id ?? null);

        $nacionalidades = $this->nacionalidadRepo->all();
        $etnias = $this->etniaRepo->all();
        $estadoCivil = $this->estadoCivilRepo->all();
        $casaTipo = $this->casaRepo->all();
        $tipoTelefonos = $this->tipoTelefonoRepo->all();

        $personaServicio = null;
        /*if($persona){
            $personaServicio = DB::table('persona_servicio')
                ->select('id')
                ->where('id_persona','=',$persona->id)
                ->where('id_tipo_persona','=',1)
                ->first();
        }*/

        return view('credito.solicitud', compact(
            'persona', 'nacionalidades','etnias',
            'estadoCivil','casaTipo','tipoTelefonos'
        ));
    }

    // PASO 1: Guardar Persona y vincular Servicio
    public function paso1(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required',
            'lugar_nacimiento' => 'required',
            'id_nacionalidad' => 'required',
            'id_etnia' => 'required',
            'id_estado_civil' => 'required',
            'numero_dpi' => 'required|string|max:13',
            'profesion_oficio' => 'required',
            'ocupacion_actual' => 'required',
            'tiempo_residencia' => 'required',
            'id_casa_tipo' => 'required',

            'telefonos_tipo' => 'nullable|array',
            'telefonos_tipo.*' => 'exists:tipo_telefono,id',
            'telefonos_numero' => 'nullable|array',
            'telefonos_numero.*' => 'digits:8',

            'porcentaje_de_aporte_familiar' => 'required',
        ]);

        $persona = $this->solicitudService->guardarPersona($validated, $request->id);

        $this->solicitudService->guardarDireccionPersona($persona, $request);

        if ($request->has('telefonos_tipo')) {
            $this->solicitudService->guardarTelefonosPersona($persona, $request);
        }

        /*$this->solicitudService->vincularPersonaServicio(
            $persona->id,
            $request->id_servicio,
            $request->idPersonaServicio
        );*/

        
        return redirect()->route(
            'solicitud-credito.servicio-financiero',
            [$persona->id, $request->id_servicio]
        );
    }

    // =======================
    // PASO 2: Mostrar formulario de Servicio Financiero y vincular persona
    // =======================
    public function mostrarPaso2($id = null)
    {
        //$servicio = null;
        /*if(session()->has('id_servicio_financiero')){
            $servicio = ServicioFinanciero::find(session('id_servicio_financiero'));
        }*/

        $persona = Persona::find($id);
        $personaServicio = DB::table('persona_servicio')->select('id_servicio_financiero','id')
        ->where('id_tipo_persona','=',1)
        ->first();

        //$servicio = ServicioFinanciero::find($id);

        $servicio = null;
        if($personaServicio){
            $servicio = ServicioFinanciero::find($personaServicio->id_servicio_financiero);
        }

        
        //$persona = Persona::find($servicio->persona_id ?? null);

        /*$personaServicio = null;
        if($persona){
            $personaServicio = DB::table('persona_servicio')
                ->select('id')
                ->where('id_persona','=',$persona->id)
                ->where('id_tipo_persona','=',1)
                ->first();
        }*/

        $oficinas = $this->oficinaRepo->all();
        $destinos = $this->destinoRepo->all();
        $tipoServicios = $this->tipoServicioRepo->all();
        $productos = $this->productoRepo->all();

        return view('credito.solicitudServicio', compact(
            'servicio', 'oficinas','destinos','tipoServicios','productos','persona','personaServicio'
        ));
    }

    // PASO 2: Guardar Servicio Financiero
    public function paso2(Request $request)
    {
        $validated = $request->validate([
            'no_beneficiario' => 'required|string|max:100',
            'no_servicio' => 'required|string|max:100',
            'fecha_solicitud' => 'required|date',
            'id_oficina' => 'required',
            'monto' => 'required',
            'plazo' => 'required',
            'tasa' => 'required',
            'id_destino' => 'required',
            'periodo_gracia' => 'required|string',
            'id_tipo_servicio' => 'required',
            'id_producto' => 'required',
        ]);

        $validated['estado'] = "datos_generales";

        $servicio = $this->solicitudService->guardarServicio($validated, $request->id);

        //dd($request);

        $this->solicitudService->vincularPersonaServicio(
            $request->id_persona,    
            $servicio->id,
            1,
            $request->idPersonaServicio
        );

        return redirect()->route(
            'solicitud-credito.datos-emprendimiento',
            [$request->id_persona, $servicio->id]
        );

        //return redirect()->route('solicitud-credito.datos-generales', $servicio->id);
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
            'establecida_casa' => 'required|string',
            'tiene_sucursales' => 'required|string',
            'plataformas' => 'nullable|string|max:255',
            'negocio_por_internet' => 'required|string',
            'programa_rngg' => 'nullable|string|max:255',
            'aspectos' => 'nullable|array',
            'aspectos.*' => 'integer|exists:aspecto_formalizacion,id',
            'redes' => 'nullable|array',
            'redes.*' => 'integer|exists:redes_sociales,id',
        ]);

        //dd($request);

        $this->solicitudService->guardarEmprendimiento($request);
        $idServicio = $request->id_servicio;

        return redirect()->route(
            'solicitud-credito.datos-conyugue',
            $idServicio
        );
    }

    //Mostrar paso 4
    //Mostrar datos del conyugue 
    public function mostrarPaso4($idServicio = null)
    {
        $nacionalidades = $this->nacionalidadRepo->all();
        $estadoCivil = $this->estadoCivilRepo->all();
        $casaTipo = $this->casaRepo->all();
        $tipoTelefonos = $this->tipoTelefonoRepo->all();
        
        $persona = null;
        $telefonos = null;
        $direcciones = null;

        $conyugueServicio  = DB::table('persona_servicio')
            ->select('id','id_persona')
            ->where('id_servicio_financiero','=',$idServicio)
            ->where('id_tipo_persona','=',2)
            ->first();
       
        if($conyugueServicio){
            $persona = Persona::find($conyugueServicio->id_persona ?? null);
            $telefonos = $persona?->telefonos;
            $direcciones = $persona?->direcciones;
            //$telefonos = $conyugue?->telefonos()->with('tipoTelefono')->get();
        }

        //$persona = Persona::find(6);
        return view('credito.solicitudConyugue', compact(
            'nacionalidades',
            'estadoCivil',
            'casaTipo',
            'idServicio',
            'conyugueServicio',
            'telefonos',
            'direcciones',
            'tipoTelefonos',
            'persona'
        ));
    }

     // PASO 3: Guardar Conyugue
    public function paso4(Request $request)
    {                
        $request->validate([
            'nombre' => 'required|string|max:40',
            'apellido' => 'required|string|max:40',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required',
            'lugar_nacimiento' => 'required',
            'id_nacionalidad' => 'required',
            'id_estado_civil' => 'required',
            'numero_dpi' => 'required|string|max:13',
            'profesion_oficio' => 'required',
            'ocupacion_actual' => 'required',
            

            // 🔥 DIRECCIONES
            'direcciones' => 'required|array',

            // domiciliar (tipo 1)
            'direcciones.1.direccion' => 'required|string',
            'direcciones.1.referencia' => 'required|string',

            'id_casa_tipo' => 'required',
            //'telefonos_tipo.*' => 'required|exists:tipo_telefono,id',
            //'telefonos_numero.*' => 'required|digits:8'

            'telefonos_tipo' => 'nullable|array',
            'telefonos_tipo.*' => 'exists:tipo_telefono,id',
            'telefonos_numero' => 'nullable|array',
            'telefonos_numero.*' => 'digits:8'
        ]);


        $personaConyugue = $this->solicitudService->guardarPersona($request->only([
            'nombre',
            'apellido',
            'numero_dpi',
            'sexo',
            'fecha_nacimiento',
            'lugar_nacimiento',
            'id_nacionalidad',
            'id_estado_civil',
            'profesion_oficio',
            'ocupacion_actual',
            'id_casa_tipo'
        ]), $request->id_persona);

        $this->solicitudService->vincularPersonaServicio(
            $personaConyugue->id,    
            $request->id_servicio,
            2,
            $request->personaServicioId
        );
        
       
        $this->solicitudService->guardarDireccionPersona($personaConyugue, $request);

        if ($request->has('telefonos_tipo')) {
            $this->solicitudService->guardarTelefonosPersona($personaConyugue, $request);
        }

        //$this->solicitudService->guardarTelefonosPersona($personaConyugue, $request);
        $idServicio = $request->id_servicio;
        return redirect()->route(
            'solicitud-credito.datos-fiador',
            $idServicio
        );
    }

    //Mostrar paso 5
    //Mostrar datos del fiador
    public function mostrarPaso5($idServicio = null)
    {
        $persona = null;
        $nacionalidades = $this->nacionalidadRepo->all();
        $estadoCivil = $this->estadoCivilRepo->all();
        $casaTipo = $this->casaRepo->all();
        $tipoTelefonos = $this->tipoTelefonoRepo->all();
        
        $fiadorServicio  = DB::table('persona_servicio')
            ->select('id','id_persona')
            ->where('id_servicio_financiero','=',$idServicio)
            ->where('id_tipo_persona','=',3)
            ->first();

        if($fiadorServicio){
            $persona = Persona::find($fiadorServicio->id_persona ?? null);
        }

        //$persona = Persona::find(6);
        return view('credito.solicitudFiador', compact(
            'nacionalidades',
            'estadoCivil',
            'casaTipo',
            'idServicio',
            'fiadorServicio',
            'tipoTelefonos',
            'persona'
        ));
    }

     // PASO 3: Guardar Conyugue
    public function paso5(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:40',
            'apellido' => 'required|string|max:40',
            'fecha_nacimiento' => 'required|date',
            'sexo' => 'required',
            'lugar_nacimiento' => 'required',
            'id_nacionalidad' => 'required',
            'id_estado_civil' => 'required',
            'numero_dpi' => 'required|string|max:13',
            'profesion_oficio' => 'required',
            'ocupacion_actual' => 'required',
            
            // domiciliar (tipo 1)
            'direcciones.1.direccion' => 'required|string',
            'direcciones.1.referencia' => 'required|string',

            // laboral (tipo 2)
            'direcciones.2.direccion' => 'required|string',

            'id_casa_tipo' => 'required',
            //'telefonos_tipo.*' => 'required|exists:tipo_telefono,id',
            //'telefonos_numero.*' => 'required|digits:8'

            'telefonos_tipo' => 'nullable|array',
            'telefonos_tipo.*' => 'exists:tipo_telefono,id',
            'telefonos_numero' => 'nullable|array',
            'telefonos_numero.*' => 'digits:8',
            'lugar_trabajo' =>'required|string',
            'nombre_cargo' => 'required|string',
            'ingreso_neto' => 'required'
        ]);

        //dd($request);

        $personaConyugue = $this->solicitudService->guardarPersona($request->only([
            'nombre',
            'apellido',
            'numero_dpi',
            'sexo',
            'fecha_nacimiento',
            'lugar_nacimiento',
            'id_nacionalidad',
            'id_estado_civil',
            'profesion_oficio',
            'ocupacion_actual',
            'id_casa_tipo',
            'lugar_trabajo',
            'nombre_cargo',
            'ingreso_neto'
        ]), $request->id_persona);

        $this->solicitudService->vincularPersonaServicio(
            $personaConyugue->id,    
            $request->id_servicio,
            3,
            $request->personaServicioId
        );
        
        $this->solicitudService->guardarDireccionPersona($personaConyugue, $request);

        if ($request->has('telefonos_tipo')) {
            $this->solicitudService->guardarTelefonosPersona($personaConyugue, $request);
        }

        //$this->solicitudService->guardarTelefonosPersona($personaConyugue, $request);
        $idServicio = $request->id_servicio;
        return redirect()->route(
            'solicitud-credito.datos-fiador',
            $idServicio
        );
    }

}