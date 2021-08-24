@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Listar o cancelar orden de reparación</h1>
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
        {{-- <div style="visibility: hidden" id="divPieza" name="divPieza">
            <form method="POST" action="{{ route('reparacionPiezaExcel') }}" target="_blank">
                @csrf
                <input type="hidden" id="piezaExcel" name="piezaExcel">
                <button type="submit" class="btn btn-success ml-2 mb-2">Excel</button>
            </form>
        </div>

        <div style="visibility: hidden" id="divFecha" name="divFecha">
            <form method="POST" action="{{ route('reparacionFechaExcel') }}" target="_blank">
                @csrf
                <input type="hidden" id="fecha1Excel" name="fecha1Excel">
                <input type="hidden" id="fecha2Excel" name="fecha2Excel">
                <button type="submit" class="btn btn-success ml-2 mb-2">Excel</button>
            </form>
        </div>

        <div style="visibility: hidden" id="divNumero" name="divNumero">
            <form method="POST" action="{{ route('reparacionNumeroExcel') }}" target="_blank">
                @csrf
                <input type="hidden" id="numeroExcel" name="numeroExcel">
                <button type="submit" class="btn btn-success ml-2 mb-2">Excel</button>
            </form>
        </div> --}}
    </div>
    </div>
    <div id="modalModificar" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar orden de reparación</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario2">
                        @csrf
                        <div class="card-body">
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-3">Orden de reparación N°:</label>
                                    <input type="text" id="ordenes" name="ordenes" class="col-2" readonly></input>
                                    <label class="col-2">Fecha:</label>
                                    <input type="text" id="fecha" name="" class="col-2" readonly></input>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-3">Herramienta:</label>
                                    <input type="text" name="herramienta" id="herramienta" class="col-2" readonly></input>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-3">Número:</label>
                                    <input type="number" min="1" max="500" class="col-2" id="numero" name="numero"></input>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-3">Supervisor de trabajo:</label>
                                    <select class="col-2 mr-2" name="" id="">
                                    </select>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-3">Operario:</label>
                                    <select class="col-2 mr-2" name="" id="">
                                    </select>
                                </div>
                            </div>
                            <section class="content">
                                <div class="container-fluid">
                                    <div class="row">
                                        <section class="col-lg-8 connectedSortable ui-sortable">
                                            <div class="conteiner-fluid" id="divtablatareas2" name="divtablatareas2">
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
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@stop
@section('js')
    <script src="{{ asset('js/reparacion-listar.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
