@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Listar o cancelar orden de construcción</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>

        <form id="formulario" method="POST" action="">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row mb-2">
                        <label class=" col mr-2">Listar por:</label>
                        <select class=" col mr-2" name="lista" id="lista">
                            <option value="0">Nro de orden de reparación</option>
                            <option value="1">Fecha</option>
                            <option value="2">Herramienta</option>
                        </select>
                        <button type="button" id="buscar" name="buscar" onclick="listarOrdenes();" disabled
                            class="btn btn-primary col">Listar</button>
                    </div>

                    <div id="filtro"></div>
                </div>
                <div class="container">
                    <div id="divtabla" name="divtabla">
                    </div>
                </div>
                <div class="container">
                    <div id="divtablatareas" name="divtablatareas">
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@stop
@section('js')
    <script src="{{ asset('js/reparacion-listar.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
