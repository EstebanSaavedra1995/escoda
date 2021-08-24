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
                            <option value="0">Nro de orden</option>
                            <option value="1">Fecha</option>
                            <option value="2">Pieza</option>
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

        <div style="visibility: hidden" id="divPieza" name="divPieza">
            <form method="POST" action="{{ route('piezaExcel') }}" target="_blank">
                @csrf
                <input type="hidden" id="piezaExcel" name="piezaExcel">
                <button type="submit" class="btn btn-success ml-2 mb-2">Excel</button>
            </form>
        </div>

        <div style="visibility: hidden" id="divFecha" name="divFecha">
            <form method="POST" action="{{ route('fechaExcel') }}" target="_blank">
                @csrf
                <input type="hidden" id="fecha1Excel" name="fecha1Excel">
                <input type="hidden" id="fecha2Excel" name="fecha2Excel">
                <button type="submit" class="btn btn-success ml-2 mb-2">Excel</button>
            </form>
        </div>

        <div style="visibility: hidden" id="divNumero" name="divNumero">
            <form method="POST" action="{{ route('numeroExcel') }}" target="_blank">
                @csrf
                <input type="hidden" id="numeroExcel" name="numeroExcel">
                <button type="submit" class="btn btn-success ml-2 mb-2">Excel</button>
            </form>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@stop
@section('js')
    <script src="{{ asset('js/listarcancelar.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
