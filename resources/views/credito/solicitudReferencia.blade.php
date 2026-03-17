@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('assets/extensions/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h1>Referencias</h1>
        </div>

        <div class="card-content">
            <div class="card-body">
                <form action="{{ route('solicitud-credito.datos-referencia') }}" method="POST">
                    @csrf

                    @isset($method)
                        @method($method)
                    @endisset
                    <input type="hidden" name="id_servicio" value="{{ $idServicio ?? '' }}">
                    <input type="hidden" name="id_persona" value="{{ $servicio->id_persona ?? '' }}">

                    <div id="referencias-container">
                        @php
                            $oldReferencias = old('referencias', $persona?->referencias ?? []);

                            $oldReferencias = array_values(
                                is_array($oldReferencias) 
                                    ? $oldReferencias 
                                    : $oldReferencias->toArray()
                            );
                        @endphp

                        @foreach($oldReferencias as $index => $ref)
                            <div class="referencia-item row {{ $errors->has("referencias.$index.*") ? 'border border-danger' : '' }}" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

                                {{-- ID oculto para update --}}
                                <input type="hidden" name="referencias[{{ $index }}][id]" value="{{ $ref['id'] ?? $ref->id ?? '' }}">

                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <label>Nombre</label>
                                    <input type="text"
                                        name="referencias[{{ $index }}][nombre]"
                                        value="{{ $ref['nombre'] ?? $ref->nombre ?? '' }}"
                                        class="form-control @error("referencias.$index.nombre") is-invalid @enderror">
                                    
                                    @error("referencias.$index.nombre")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <label>Apellido</label>
                                    <input type="text"
                                        name="referencias[{{ $index }}][apellido]"
                                        value="{{ $ref['apellido'] ?? $ref->apellido ?? '' }}"
                                        class="form-control">

                                    @error("referencias.$index.apellido")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <label>Teléfono</label>
                                    <input type="text"
                                        name="referencias[{{ $index }}][numero_telefono]"
                                        value="{{ $ref['numero_telefono'] ?? $ref->numero_telefono ?? '' }}"
                                        class="form-control"                                 
                                        maxlength="8"
                                        pattern="[0-9]{8}">

                                    @error("referencias.$index.numero_telefono")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <label>Tipo Relación</label>
                                    <input type="text"
                                        name="referencias[{{ $index }}][tipo_relacion]"
                                        value="{{ $ref['tipo_relacion'] ?? $ref->tipo_relacion ?? '' }}"
                                        class="form-control">

                                    @error("referencias.$index.tipo_relacion")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label>Tipo Referencia</label>
                                    <select name="referencias[{{ $index }}][id_tipo_referencia]" class="form-select">
                                        <option value="">Seleccione</option>
                                        @foreach($tipoReferencias as $tipo)
                                            <option value="{{ $tipo->id }}"
                                                @if(
                                                    ($ref['id_tipo_referencia'] ?? $ref->id_tipo_referencia ?? '') == $tipo->id
                                                ) selected @endif>
                                                {{ $tipo->nombre }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error("referencias.$index.id_tipo_referencia")
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: flex; justify-content: center; margin-top:10px;">
                                    <button type="button" class="btn btn-danger btn-remove">Eliminar</button>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <button class="btn btn-success" type="button" id="add-referencia">+ Agregar referencia</button>

                    <br><br>

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



<script src="{{asset('assets/extensions/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('assets/extensions/flatpickr/l10n/es.js')}}"></script>

<script src="{{asset('assets/static/js/pages/date-picker.js')}}"></script>

<script src="{{asset('assets/extensions/choices.js/public/assets/scripts/choices.js')}}"></script>
<script src="{{asset('assets/static/js/pages/form-element-select.js')}}"></script>

<script>
let index = {{ count(old('referencias', $persona?->referencias ?? [])) }};

const tiposReferencia = @json($tipoReferencias);

document.getElementById('add-referencia').addEventListener('click', function () {

    let options = '<option value="">Seleccione</option>';

    tiposReferencia.forEach(tipo => {
        options += `<option value="${tipo.id}">${tipo.nombre}</option>`;
    });

    const html = `
        <div class="referencia-item row {{ $errors->has("referencias.$index.*") ? 'border border-danger' : '' }}" style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">

            <input type="hidden" name="referencias[${index}][id]">

            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <label>Nombre</label>
                <input type="text" name="referencias[${index}][nombre]" class="form-control">
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <label>Apellido</label>
                <input type="text" name="referencias[${index}][apellido]" class="form-control">
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <label>Teléfono</label>
                <input type="text" name="referencias[${index}][numero_telefono]" class="form-control" maxlength="8" pattern="[0-9]{8}">
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                <label>Tipo Relación</label>
                <input type="text" name="referencias[${index}][tipo_relacion]" class="form-control">
            </div>

            <div>
                <label>Tipo Referencia</label>
                <select name="referencias[${index}][id_tipo_referencia]" class="form-select">
                    ${options}
                </select>
            </div>

            
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="display: flex; justify-content: center; margin-top:10px;">
                <button type="button" class="btn-remove btn btn-danger">Eliminar</button>
            </div>
        </div>
    `;

    document.getElementById('referencias-container')
        .insertAdjacentHTML('beforeend', html);

    index++;
});

// eliminar
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-remove')) {
        e.target.closest('.referencia-item').remove();
    }
});
</script>




@endsection
