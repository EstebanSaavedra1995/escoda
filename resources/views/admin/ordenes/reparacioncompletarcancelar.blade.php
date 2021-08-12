@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
<h1>Completar o cancelar odenreparación</h1>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"></h3>
    </div>
    <form id="formulario">
        @csrf
        <div class="card-body">
            <div class="container">
                <div class="row mb-2">
                    <label class="col-2">Orden de reparación N°:</label>
                    <select class="col-2 mr-2" name="ordenes" id="ordenes">
                        <option value="">Ordenes</option>
                        @foreach ($ordenesPendientes as $ordenPendiente)
                            <option value="{{ $ordenPendiente->codConjunto }}">{{ $ordenPendiente->NroOR }}</option>
                        @endforeach
                    </select>
                    <label class="col-2">Fecha:</label>
                    <input type="text" id="fecha" name="" class="col-2" readonly></input>
                </div>
            </div>
            <div class="container">
                <div class="row mb-2">
                    <label class="col-2">Herramienta:</label>
                    <input type="text" name="herramienta" id="herramienta" class="col-2" readonly></input>
                </div>
            </div>
            <div class="container">
                <div class="row mb-2">
                    <label class="col-2">Número:</label>
                    <input type="number" min="1" max="500" class="col-2"></input>
                </div>
            </div>
            <div class="container">
                <div class="row mb-2">
                    <label class="col-2">Supervisor de trabajo:</label>
                    <select class="col-2 mr-2" name="" id="">
                        <option value="">Supervisor</option>
                        @foreach ($supervisores as $supervisor)
                            <option value="{{ $supervisor->NroLegajo }}">{{ $supervisor->NroLegajo }} -
                                {{ $supervisor->ApellidoNombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="container">
                <div class="row mb-2">
                    <label class="col-2">Operario:</label>
                    <select class="col-2 mr-2" name="" id="">
                        <option value="">Operario</option>
                        @foreach ($operarios as $operario)
                            <option value="{{ $operario->NroLegajo }}">{{ $operario->NroLegajo }} -
                                {{ $operario->ApellidoNombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <section class="col-lg-8 connectedSortable ui-sortable">
                            <div class="conteiner-fluid" id="divtablatareas" name="divtablatareas">
                            </div>
                        </section>
                        <section class="col-lg-4 connectedSortable ui-sortable">
                            <div class="container-fluid">
                                <div class="row" id="lateral" name="lateral"></div>
                                <div class="row" id="lateral2" name="lateral2"></div>
                                <div class="row" id="lateral3" name="lateral3"></div>
                                <div class="row" id="lateral4" name="lateral4"></div>
                            </div>
                        </section>
                    </div>
                </div>
            </section>
        </div>
    </form>
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@stop
@section('js')
<script src="{{ asset('js/reparacion-completarcancelar.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
