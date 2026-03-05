@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('assets/extensions/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">

<div class="">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>Datos Del Emprendimiento/MIPYME</h1>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('solicitud-credito.datos-emprendimiento') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $emprendimiento->id ?? '' }}">
                        <input type="hidden" name="id_persona" value="{{$idPersona ?? ''}}">
                        <input type="hidden" name="id_servicio" value="{{ $idServicio ?? '' }}">
                    
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Nombre Del Emprendimiento/MYPE</label>
                                <input type="text" name="nombre" class="form-control" 
                                value="{{ old('nombre', $emprendimiento->nombre ?? '') }}">
                                @error('nombre')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!--
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Dirección Empresa</label>
                                <input type="text" name="direccion" class="form-control" 
                                value="{{ old('direccion', $emprendimiento->direccion ?? '') }}">
                                @error('direccion')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            -->

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Giro Del Negocio</label>
                                <input type="text" name="giro_negocio" class="form-control" 
                                value="{{ old('giro_negocio', $emprendimiento->giro_negocio ?? '') }}">
                                @error('giro_negocio')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label>Actividad Economica</label>
                                <select class="choices form-select" 
                                    id="id_actividad_economica" 
                                    name="id_actividad_economica">

                                    <option value="">-- Seleccione --</option>

                                    @foreach($actividadEconomicas as $nac)
                                        <option value="{{ $nac->id }}"
                                            {{ old('id_actividad_economica', $emprendimiento->id_actividad_economica ?? '') == $nac->id ? 'selected' : '' }}>
                                            {{ $nac->nombre }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('id_actividad_economica')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        

                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label>Fecha De La Empresa</label>
                                <input type="text" name="fecha" class="form-control" id="fecha"
                                value="{{ old('fecha', isset($emprendimiento->fecha) ? \Carbon\Carbon::parse($emprendimiento->fecha)->format('d/m/Y') : '') }}">

                                @error('fecha')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Esta Constituida Legalmente Su Empresa</label>
                                <div class="input-group">
                                    <div class="radio radio-success radio-inline" style="padding-right: 10px;">
                                        <input class="form-check-input" type="radio" name="constituida_legalmente" id="constituida_si" value="Si" 
                                        {{ old('constituida_legalmente', $emprendimiento->constituida_legalmente ?? '') == 'Si' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="constituida_si">Si</label>
                                    </div>
                                    <div class="radio radio-danger radio-inline">
                                        <input class="form-check-input" type="radio" name="constituida_legalmente" id="constituida_no" value="No"
                                        {{ old('constituida_legalmente', $emprendimiento->constituida_legalmente ?? '') == 'No' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="constituida_no">No</label>
                                    </div>
                                </div>
                                @error('constituida_legalmente')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Aspectos De Formalización</label>

                                <ul class="list-unstyled mb-0">
                                @foreach($aspectoFormalizaciones as $aspecto)
                                    <li class="d-inline-block me-2 mb-1">
                                        <div class="form-check">
                                            <input type="checkbox"
                                                name="aspectos[]"
                                                value="{{ $aspecto->id }}"
                                                class="form-check-input"
                                                id="aspecto{{ $aspecto->id }}"
                                                @checked(
                                                    old('aspectos')
                                                        ? in_array($aspecto->id, old('aspectos'))
                                                        : (isset($emprendimiento) && $emprendimiento->aspectosFormalizacion->contains($aspecto->id))
                                                )
                                            >
                                            <label for="aspecto{{ $aspecto->id }}">
                                                {{ $aspecto->nombre }}
                                            </label>
                                        </div>
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Cantidad De Empleados</label>
                            </div>
                                <div class="col-md-6">
                                    <div class="form-group">                               
                                        <label class="control-label">Masculino</label>
                                        <input type="number" name="empleado_masculino" class="form-control" min="0" value="{{ old('empleado_masculino', $emprendimiento->empleado_masculino ?? 0) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">  
                                        <label class="control-label">Femenino</label>
                                        <input type="number" name="empleado_femenino" class="form-control" min="0" value="{{ old('empleado_femenino', $emprendimiento->empleado_femenino ?? 0) }}">
                                    </div>
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                                <label class="control-label">Tiene Sucursales</label>
                                <div class="input-group">
                                    <div class="radio radio-success radio-inline" style="padding-right: 10px;">
                                        <input class="form-check-input" type="radio" name="tiene_sucursales" id="tiene_sucursal_si" value="Si" 
                                        {{ old('tiene_sucursales', $emprendimiento->tiene_sucursales ?? '') == 'Si' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tiene_sucursal_si">Si</label>
                                    </div>
                                    <div class="radio radio-danger radio-inline">
                                        <input class="form-check-input" type="radio" name="tiene_sucursales" id="tiene_sucursal_no" value="No"
                                        {{ old('tiene_sucursales', $emprendimiento->tiene_sucursales ?? '') == 'No' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tiene_sucursal_no">No</label>
                                    </div>
                                </div>
                                @error('tiene_sucursales')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- opcion para agregar direcciones de sucursales -->

                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                                <label class="control-label">¿ Esta La Empresa Establecida En Su Casa ?</label>
                                <div class="input-group">
                                    <div class="radio radio-success radio-inline" style="padding-right: 10px;">
                                        <input class="form-check-input" type="radio" name="establecida_casa" id="empresa_casa_si" value="Si" 
                                        {{ old('establecida_casa', $emprendimiento->establecida_casa ?? '') == 'Si' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="empresa_casa_si">Si</label>
                                    </div>
                                    <div class="radio radio-danger radio-inline">
                                        <input class="form-check-input" type="radio" name="establecida_casa" id="empresa_casa_no" value="No"
                                        {{ old('establecida_casa', $emprendimiento->establecida_casa ?? '') == 'No' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="empresa_casa_no">No</label>
                                    </div>
                                </div>
                                @error('establecida_casa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- opcion para agregar direcciones de sucursales -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">¿Qué Redes Sociales Utiliza?</label>

                                <!-- Contenedor donde se agregan las redes dinámicamente -->
                                <div id="redes-container">
                                    @if(isset($emprendimiento))
                                        @foreach($emprendimiento->redesSociales as $index => $red)
                                            <div class="row mt-2 red-item" data-id="{{ $index }}">
                                                <div class="col-md-6">
                                                    <select name="redes[]" class="form-select red-select" required>
                                                        <option value="">Seleccione Red</option>
                                                        @foreach($redesSociales as $opcion)
                                                            <option value="{{ $opcion->id }}"
                                                                {{ $opcion->id == $red->id ? 'selected' : '' }}>
                                                                {{ $opcion->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger eliminar-red">X</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Botón para agregar más redes -->
                                <button type="button" class="btn btn-sm btn-success mt-2" onclick="agregarRedSocial()">
                                    + Agregar Red Social
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
                                <label class="control-label">¿ Ha Realizado Negocios Por Internet ?</label>
                                <div class="input-group" >
                                    <div class="radio radio-success radio-inline" style="padding-right: 10px;">
                                        <input class="form-check-input" type="radio" name="negocio_por_internet" id="negocio_por_internet_si" value="Si" 
                                        {{ old('negocio_por_internet', $emprendimiento->negocio_por_internet ?? '') == 'Si' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="negocio_por_internet_si">Si</label>
                                    </div>
                                    <div class="radio radio-danger radio-inline">
                                        <input class="form-check-input" type="radio" name="negocio_por_internet" id="negocio_por_internet_no" value="No"
                                        {{ old('negocio_por_internet', $emprendimiento->negocio_por_internet ?? '') == 'No' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="negocio_por_internet_no">No</label>
                                    </div>
                                </div>
                                @error('negocio_por_internet')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- opcion para agregar plataformas de sucursales -->
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">¿ En Que Plataformas ?</label>
                                <input type="text" name="plataformas" class="form-control" 
                                value="{{ old('plataformas', $emprendimiento->plataformas ?? '') }}">
                                @error('plataformas')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Programa RNGG En El Que Participa</label>
                                <input type="text" name="programa_rngg" class="form-control" 
                                value="{{ old('programa_rngg', $emprendimiento->programa_rngg ?? '') }}">
                                @error('programa_rngg')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row" style="margin-top:10px;">
                            <div style="display: flex; justify-content: right;">
                                <button type="submit" class="btn btn-primary">Siguiente</button>
                            </div>
                            
                        </div>        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="{{asset('assets/extensions/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/extensions/flatpickr/l10n/es.js')}}"></script>

<script src="{{asset('assets/static/js/pages/date-picker.js')}}"></script>

<script src="{{asset('assets/extensions/choices.js/public/assets/scripts/choices.js')}}"></script>
<script src="{{asset('assets/static/js/pages/form-element-select.js')}}"></script>
<script>
    flatpickr("#fecha", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
    locale: flatpickr.l10ns.es
});    
</script>

<script>
    // Convertimos $redesSociales a un array de objetos JS
    const redesDisponibles = @json($redesSociales->map(fn($r) => ['id' => $r->id, 'nombre' => $r->nombre]));
    
    let contadorRedes = document.querySelectorAll('.red-item').length;

    function agregarRedSocial() {
        const usadas = obtenerRedesSeleccionadas();

        if (usadas.length >= redesDisponibles.length) {
            alert("Ya agregó todas las redes disponibles.");
            return;
        }

        const container = document.getElementById('redes-container');

        const div = document.createElement('div');
        div.classList.add('row','mt-2','red-item');
        div.setAttribute('data-id', contadorRedes);

        let opciones = '<option value="">Seleccione Red</option>';

        redesDisponibles.forEach(red => {
            if (!usadas.includes(red.id)) {
                opciones += `<option value="${red.id}">${red.nombre}</option>`;
            }
        });

        div.innerHTML = `
            <div class="col-md-6">
                <select name="redes[]" class="form-select red-select" required>
                    ${opciones}
                </select>
            </div>

            <div class="col-md-2">
                <button type="button" class="btn btn-danger eliminar-red">
                    X
                </button>
            </div>
        `;

        container.appendChild(div);
        contadorRedes++;
    }

    function obtenerRedesSeleccionadas() {
        let seleccionadas = [];
        document.querySelectorAll('.red-select').forEach(select => {
            if (select.value) {
                seleccionadas.push(Number(select.value));
            }
        });
        return seleccionadas;
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('eliminar-red')) {
            e.target.closest('.red-item').remove();
        }
    });
</script>
@endsection
