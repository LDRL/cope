@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{asset('assets/extensions/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/extensions/choices.js/public/assets/styles/choices.css')}}">

<div class="page-heading">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h1>Listado de creditos en proceso</h1>
            </div>

            <div class="card-content">
                <div class="card-body">
                    @if (isset($servicios))      
                    <div class="row">

                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                        <th>Id</th>
                                        <th>Identificación</th>
                                        <th>Nombre</th>
                                        <th>No. De Beneficiario</th>
                                        <th>No. De Servicio Financiero</th>
                                        <th>Estado</th>
                                        <th style="width: 20%">Opciones</th>
                                    </thead>
                                    @foreach ($servicios as $ser)
                                    <tr>
                                        <td>{{$ser->id}}</td>
                                        <td>{{$ser->numero_dpi}}</td>
                                        <td>{{$ser->nombre.' '. $ser->apellido}}</td>
                                        <td>{{$ser->personaServicio->servicioFinanciero->no_beneficiario ?? '' }}</td>
                                        <td>{{$ser->personaServicio->servicioFinanciero->no_servicio ?? '' }}</td>       
                                        <td>{{$ser->personaServicio->servicioFinanciero->estado ?? 'servicio_financiero' }}</td>                                 
                                        <td></td>
                                    </tr>

                                    @endforeach
                                </table>
                                {{ $servicios->links() }}
                            </div>
                    </div>
                    </div>
                @endif
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

@endsection
