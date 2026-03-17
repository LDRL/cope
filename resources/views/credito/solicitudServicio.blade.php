@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('assets/extensions/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">

<div class="page-heading">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>Paso 1: Solicitud de Servicio Financiero</h1>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <form action="{{ route('solicitud-credito.servicio-financiero') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $servicio->id ?? '' }}">
                        <input type="hidden" name="id_persona" value="{{ $persona->id ?? '' }}">
                        <input type="hidden" name="idPersonaServicio" value="{{$personaServicio->id ?? ''}}">

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">No. De Beneficiario(A)</label>
                                <input type="text" name="no_beneficiario" class="form-control" 
                                value="{{ old('no_beneficiario', $servicio->no_beneficiario ?? '') }}">
                                @error('no_beneficiario')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">No. De Servicio Financiero</label>
                                <input type="text" name="no_servicio" class="form-control" 
                                value="{{ old('no_servicio', $servicio->no_servicio ?? '') }}">
                                @error('no_servicio')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Fecha de solicitud</label>
                                <!-- input type="date" name="fecha_solicitud" class="form-control" value="{{ old('fecha_solicitud', $servicio->fecha_solicitud ?? '') }}" -->
                                <input type="text" name="fecha_solicitud" class="form-control" id="fecha_solicitud"
                                value="{{ old('fecha_solicitud', isset($servicio->fecha_solicitud) ? \Carbon\Carbon::parse($servicio->fecha_solicitud)->format('d/m/Y') : '') }}">

                                @error('fecha_solicitud')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Oficina</label>
                                <select class="choices form-select" id="id_oficina" name="id_oficina">
                                @if (isset($oficinas))
                                @foreach($oficinas as $ofi)
                                @if(isset($servicio) && $servicio->id_oficina == $ofi->id)
                                <option value="{{$ofi->id}}" selected="">{{$ofi->nombre}}</option>
                                @else
                                <option value="{{$ofi->id}}">{{$ofi->nombre}}</option>
                                @endif
                        
                                @endforeach
                                @endif
                                </select>

                                @error('id_oficina')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Monto solicitado</label>
                                <input type="number" name="monto" class="form-control" min="0" value="{{ old('monto', $servicio->monto ?? 0) }}">
                                @error('monto')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Destino</label>
                                <select class="choices form-select" id="id_destino" name="id_destino">
                                @if (isset($destinos))
                                @foreach($destinos as $des)
                                @if(isset($servicio) && $servicio->id_destino == $des->id)
                                <option value="{{$des->id}}" selected="">{{$des->nombre}}</option>
                                @else
                                <option value="{{$des->id}}">{{$des->nombre}}</option>
                                @endif
                        
                                @endforeach
                                @endif
                                </select>

                                @error('id_destino')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label>Plazo (meses)</label>
                                <input type="number" name="plazo" class="form-control" min="0" value="{{ old('plazo', $servicio->plazo ?? 0) }}">
                                @error('plazo')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label>Tasa </label>
                                <div class="input-group mb-3">
                                    <input type="number" name="tasa" class="form-control" min="0" value="{{ old('tasa', $servicio->tasa ?? 0) }}">
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('tasa')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                                <label class="control-label">Periodo de gracia</label>
                                <div class="input-group">
                                    <div class="radio radio-success radio-inline">
                                        <input class="form-check-input" type="radio" name="periodo_gracia" id="periodo_gracia_si" value="Si" 
                                        {{ (isset($servicio) && $servicio->periodo_gracia == 'Si') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="periodo_gracia_si">Si</label>
                                    </div>
                                    <div class="radio radio-danger radio-inline">
                                        <input class="form-check-input" type="radio" name="periodo_gracia" id="periodo_gracia_no" value="No"
                                        {{ (isset($servicio) && $servicio->periodo_gracia == 'No') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="periodo_gracia_no">No</label>
                                    </div>
                                </div>
                                @error('periodo_gracia')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Tipo de servicio financiero</label>
                                <select class="choices form-select" id="id_tipo_servicio" name="id_tipo_servicio">
                                @if (isset($tipoServicios))
                                @foreach($tipoServicios as $tip)
                                @if(isset($servicio) && $servicio->id_tipo_servicio == $tip->id)
                                <option value="{{$tip->id}}" selected="">{{$tip->nombre}}</option>
                                @else
                                <option value="{{$tip->id}}">{{$tip->nombre}}</option>
                                @endif
                        
                                @endforeach
                                @endif
                                </select>

                                @error('id_tipo_servicio')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <label>Producto</label>
                                <div class="form-group">
                                    <select class="choices form-select" id="id_producto" name="id_producto">
                                    @if (isset($productos))
                                    @foreach($productos as $pro)
                                    @if(isset($servicio) && $servicio->producto_id == $pro->id)
                                    <option value="{{$pro->id}}" selected="">{{$pro->nombre}}</option>
                                    @else
                                    <option value="{{$pro->id}}">{{$pro->nombre}}</option>
                                    @endif                            
                                    @endforeach
                                    @endif
                                    </select>

                                    @error('id_producto')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div>
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
    flatpickr("#fecha_solicitud", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "d/m/Y",
    locale: flatpickr.l10ns.es
});

    
</script>
@endsection
