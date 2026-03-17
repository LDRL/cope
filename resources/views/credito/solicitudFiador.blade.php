@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('assets/extensions/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">

<div class="">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>Datos Generales Del Fiador</h1>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('solicitud-credito.datos-fiador') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_servicio" value="{{ $idServicio ?? '' }}">
                        <input type="hidden" name="id_persona" value="{{ $persona->id ?? '' }}">
                        <input type="hidden" name="personaServicioId" value="{{$fiadorServicio->id ?? ''}}">

                        
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control" 
                                    value="{{ old('nombre', $persona->nombre ?? '') }}">

                                @error('nombre')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Apellido</label>
                                <input type="text" name="apellido" class="form-control" 
                                    value="{{ old('apellido', $persona->apellido ?? '') }}">

                                @error('apellido')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Numero De DPI</label>
                                <input type="text" name="numero_dpi" class="form-control" maxlength="13"
                                    value="{{ old('numero_dpi', $persona->numero_dpi ?? '') }}">

                                @error('numero_dpi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Sexo</label>
                                <div class="input-group">
                                    <div class="radio radio-success radio-inline">
                                        <input class="form-check-input" type="radio" name="sexo" id="sexo_m" value="M" 
                                        {{ old('sexo', $persona->sexo ?? '') == 'M' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sexo_m">Masculino</label>
                                    </div>
                                    <div class="radio radio-danger radio-inline">
                                        <input class="form-check-input" type="radio" name="sexo" id="sexo_f" value="F"
                                        {{ old('sexo', $persona->sexo ?? '') == 'F' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sexo_f">Femenino</label>
                                    </div>
                                </div>
                                @error('sexo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Fecha De Nacimiento</label>
                                <input type="text" name="fecha_nacimiento" class="form-control" id="fecha_nacimiento"
                                value="{{ old('fecha_nacimiento', isset($persona->fecha_nacimiento) ? \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y') : '') }}">

                                @error('fecha_nacimiento')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Lugar De Nacimiento</label>
                                <input type="text" name="lugar_nacimiento" class="form-control" 
                                    value="{{ old('lugar_nacimiento', $persona->lugar_nacimiento ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Nacionalidad</label>
                                <select class="choices form-select" 
                                    id="id_nacionalidad" 
                                    name="id_nacionalidad">
                                    <option value="">-- Seleccione --</option>
                                    @foreach($nacionalidades as $nac)
                                        <option value="{{ $nac->id }}"
                                            {{ old('id_nacionalidad', $persona->id_nacionalidad ?? '') == $nac->id ? 'selected' : '' }}>
                                            {{ $nac->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_nacionalidad')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Estado Civil</label>
                                <select class="choices form-select" id="id_estado_civil" name="id_estado_civil">
                                    <option value="">-- Seleccione --</option>
                                    @if (isset($estadoCivil))
                                    @foreach($estadoCivil as $tip)
                                        <option value="{{ $tip->id }}"
                                            {{ old('id_estado_civil', $persona->id_estado_civil ?? '') == $tip->id ? 'selected' : '' }}>
                                            {{ $tip->nombre }}
                                        </option>                            
                                    @endforeach
                                    @endif
                                </select>

                                @error('id_estado_civil')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror                             
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Profesión U Oficio</label>
                                <input type="text" name="profesion_oficio" class="form-control" 
                                    value="{{ old('profesion_oficio', $persona->profesion_oficio ?? '') }}">

                                @error('profesion_oficio')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror   
                            </div>
                            
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Ocupación Actual</label>
                                <input type="text" name="ocupacion_actual" class="form-control" 
                                    value="{{ old('ocupacion_actual', $persona->ocupacion_actual ?? '') }}">

                                @error('ocupacion_actual')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror   
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Dirección Domiciliar</label>
                                <input type="text" name="direcciones[1][direccion]" class="form-control" 
                                    value="{{ old('direcciones.1.direccion', optional($persona?->direcciones->where('id_tipo_direccion',1)->first())->direccion) }}">

                                @error('direcciones.1.direccion')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Referencia De Dirección</label>
                                <input type="text" name="direcciones[1][referencia]" class="form-control"
                                    value="{{ old('direcciones.1.referencia', optional($persona?->direcciones->where('id_tipo_direccion',1)->first())->referencia) }}">
                                @error('direcciones.1.referencia')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label>Lugar De Trabajo</label>
                                <input type="text" name="lugar_trabajo" class="form-control" 
                                    value="{{ old('lugar_trabajo', $persona->lugar_trabajo ?? '') }}">

                                @error('lugar_trabajo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror   
                            </div>
                            
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label>Nombre Del Cargo</label>
                                <input type="text" name="nombre_cargo" class="form-control" 
                                    value="{{ old('nombre_cargo', $persona->nombre_cargo ?? '') }}">

                                @error('nombre_cargo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror   
                            </div>

                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label>Ingreso Mensual Neto</label>
                                <input type="text" name="ingreso_neto" class="form-control" 
                                    value="{{ old('cargo', $persona->ingreso_neto ?? '') }}">

                                @error('ingreso_neto')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror   
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Dirección Trabajo</label>
                                <input type="text" name="direcciones[2][direccion]" class="form-control" 
                                    value="{{ old('direcciones.2.direccion', optional($persona?->direcciones->where('id_tipo_direccion',2)->first())->direccion) }}">

                                @error('direcciones.2.direccion')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>La Casa En Que Vive Es</label>
                                <select class="choices form-select" id="id_casa_tipo" name="id_casa_tipo">
                                    <option value="">-- Seleccione --</option>
                                    @if (isset($casaTipo))
                                    @foreach($casaTipo as $tip)
                                        <option value="{{ $tip->id }}"
                                            {{ old('id_casa_tipo', $persona->id_casa_tipo ?? '') == $tip->id ? 'selected' : '' }}>
                                            {{ $tip->nombre }}
                                        </option>                            
                                    @endforeach
                                    @endif
                                </select>

                                @error('id_casa_tipo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">¿Qué Telefonos Utiliza?</label>

                                <!-- Contenedor donde se agregan los telefonos dinámicamente -->
                                <div id="telefonos-container">
                                    @if(isset($persona))
                                        @foreach($persona->telefonos as $index => $tel)
                                            <div class="row mt-2 tel-item" data-id="{{ $index }}">
                                                <div class="col-md-4">
                                                    <select name="telefonos_tipo[]" class="form-select tel-select" required>
                                                        <option value="">Seleccione Telefono</option>
                                                        @foreach($tipoTelefonos as $opcion)
                                                            <option value="{{ $opcion->id }}"
                                                                {{ $opcion->id == $tel->id_tipo_telefono ? 'selected' : '' }}>
                                                                {{ $opcion->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-4">
                                                    <input 
                                                        type="number"
                                                        name="telefonos_numero[]"
                                                        class="form-control"
                                                        value="{{ $tel->numero }}"
                                                        maxlength="8"
                                                        required
                                                        pattern="[0-9]{8}"
                                                    >
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger eliminar-tel">X</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <!-- Botón para agregar más telefonos -->
                                <button type="button" id="agregarTelefono" class="btn btn-sm btn-success mt-2">
                                    + Agregar Telefono
                                </button>
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
    flatpickr("#fecha_nacimiento", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
    locale: flatpickr.l10ns.es
});    
</script>

<script>
    // Convertimos $redesSociales a un array de objetos JS
    const telefonosDisponibles = @json($tipoTelefonos);

    const container = document.getElementById("telefonos-container");
    const btnAgregar = document.getElementById("agregarTelefono");

    btnAgregar.addEventListener("click", agregarTelefono);

    function agregarTelefono() {

        const usados = [...document.querySelectorAll(".tel-select")]
            .map(e => e.value)
            .filter(v => v);

        if (usados.length >= telefonosDisponibles.length) {
            alert("Ya agregó todos los tipos de teléfono disponibles.");
            return;
        }

        let opciones = `<option value="">Seleccione teléfono</option>`;

        telefonosDisponibles.forEach(t => {
            if (!usados.includes(String(t.id))) {
                opciones += `<option value="${t.id}">${t.nombre}</option>`;
            }
        });

        const row = document.createElement("div");
        row.className = "row mt-2 tel-item";

        row.innerHTML = `
            <div class="col-md-4">
                <select name="telefonos_tipo[]" class="form-select tel-select" required>
                    ${opciones}
                </select>
            </div>

            <div class="col-md-4">
                <input 
                    type="tel"
                    name="telefonos_numero[]"
                    class="form-control tel-numero"
                    placeholder="Ej: 34569090"
                    pattern="[0-9]{8}"
                    maxlength="8"
                    required
                >
            </div>

            <div class="col-md-2">
                <button type="button" class="btn btn-danger eliminar">
                    X
                </button>
            </div>
        `;

        container.appendChild(row);
    }

    container.addEventListener("click", function(e) {

        if (e.target.classList.contains("eliminar")) {
            e.target.closest(".tel-item").remove();
        }

    });
</script>


@endsection
