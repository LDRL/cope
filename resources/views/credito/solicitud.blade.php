@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('assets/extensions/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">
<div class="page-heading">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>Datos Generales Del(la) Beneficiario(a)</h1>
            </div>

            <div class="card-content">
                <div class="card-body">

                    <form action="{{ route('solicitud-credito.datos-generales') }}" method="POST">
                        @csrf
                        <input type="hidden" name="servicio_id" value="{{ $servicio->id ?? '' }}">
                        <input type="hidden" name="id" value="{{ $persona->id ?? '' }}">
                        <input type="hidden" name="idPersonaServicio" value="{{$personaServicio->id ?? ''}}">
                        
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control" 
                                    value="{{ old('nombre', $persona->nombre ?? '') }}">
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Apellido</label>
                                <input type="text" name="apellido" class="form-control" 
                                    value="{{ old('apellido', $persona->apellido ?? '') }}">
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
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Lugar De Nacimiento</label>
                                <input type="text" name="lugar_nacimiento" class="form-control" 
                                    value="{{ old('lugar_nacimiento', $persona->lugar_nacimiento ?? '') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Nacionalidad</label>
                                <select class="choices form-select" 
                                    id="nacionalidad_id" 
                                    name="nacionalidad_id">

                                    <option value="">-- Seleccione --</option>

                                    @foreach($nacionalidades as $nac)
                                        <option value="{{ $nac->id }}"
                                            {{ old('nacionalidad_id', $persona->nacionalidad_id ?? '') == $nac->id ? 'selected' : '' }}>
                                            {{ $nac->nombre }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('nacionalidad_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Numero De DPI</label>
                                <input type="text" name="numero_dpi" class="form-control" maxlength="13"
                                    value="{{ old('numero_dpi', $persona->numero_dpi ?? '') }}">

                                @error('numero_dpi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Etnia</label>
                                <select class="choices form-select" id="etnia_id" name="etnia_id">
                                    <option value="">-- Seleccione --</option>                                    
                                    @if (isset($etnias))
                                    @foreach($etnias as $tip)
                                    <option value="{{ $tip->id }}"
                                        {{ old('etnia_id', $persona->etnia_id ?? '') == $tip->id ? 'selected' : '' }}>
                                        {{ $tip->nombre }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>

                                @error('etnia_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror                             
                            </div>
                            
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Estado Civil</label>
                                <select class="choices form-select" id="estado_civil_id" name="estado_civil_id">
                                    <option value="">-- Seleccione --</option>
                                    @if (isset($estadoCivil))
                                    @foreach($estadoCivil as $tip)
                                        <option value="{{ $tip->id }}"
                                            {{ old('estado_civil_id', $persona->estado_civil_id ?? '') == $tip->id ? 'selected' : '' }}>
                                            {{ $tip->nombre }}
                                        </option>                            
                                    @endforeach
                                    @endif
                                </select>

                                @error('estado_civil_id')
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
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">No. De Dependientes</label>
                                <input type="number" name="no_dependientes" class="form-control" min="0" value="{{ old('no_dependientes', $persona->no_dependientes ?? 0) }}">
                                @error('no_dependientes')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>% De Aporte Familiar </label>
                                <div class="input-group mb-3">
                                    <input type="number" name="porcentaje_de_aporte_familiar" class="form-control" min="0" value="{{ old('porcentaje_de_aporte_familiar', $servicio->porcentaje_de_aporte_familiar ?? 0) }}">
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('porcentaje_de_aporte_familiar')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Número De Teléfono Movil</label>
                                <input type="number" name="celular" class="form-control"  maxlength="8" min="0"  value="{{ old('celular', $persona->celular ?? "") }}">
                                @error('celular')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Número De Teléfono Casa</label>
                                <input type="number" name="numero_telefonico_casa" class="form-control" maxlength="8" min="0"  value="{{ old('numero_telefonico_casa', $persona->numero_telefonico_casa ?? "") }}">
                                @error('numero_telefonico_casa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Otro Número De Teléfono</label>
                                <input type="number" name="numero_telefonico_otro" class="form-control" maxlength="8" min="0" value="{{ old('numero_telefonico_otro', $persona->numero_telefonico_otro ?? "") }}">
                                @error('numero_telefonico_otro')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Dirección Domiciliar</label>
                                <input type="text" name="direccion_domiciliar" class="form-control" 
                                    value="{{ old('direccion_domiciliar', $persona->direccion_domiciliar ?? '') }}">

                                @error('direccion_domiciliar')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Referencia De Dirección</label>
                                <input type="text" name="referencia_de_direccion" class="form-control" 
                                    value="{{ old('referencia_de_direccion', $persona->referencia_de_direccion ?? '') }}">
                                @error('referencia_de_direccion')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Tiempo De Residir En Esta Dirección</label>
                                <input type="number" name="tiempo_residencia" class="form-control" min="0" value="{{ old('tiempo_residencia', $persona->tiempo_residencia ?? 0) }}">
                                @error('tiempo_residencia')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>La Casa En Que Vive Es</label>
                                <select class="choices form-select" id="casa_tipo_id" name="casa_tipo_id">
                                    <option value="">-- Seleccione --</option>
                                    @if (isset($casaTipo))
                                    @foreach($casaTipo as $tip)
                                        <option value="{{ $tip->id }}"
                                            {{ old('casa_tipo_id', $persona->casa_tipo_id ?? '') == $tip->id ? 'selected' : '' }}>
                                            {{ $tip->nombre }}
                                        </option>                            
                                    @endforeach
                                    @endif
                                </select>

                                @error('casa_tipo_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror                             
                                
                            </div>
                        </div>

                        <!-- Agrega aquí los campos restantes -->

                        <button type="submit" class="btn btn-primary">Siguiente</button>
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
@endsection
