@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Listar o cancelar orden de ensamble</h1>
@stop

@section('content')
    <div class="card card-primary">
        {{-- <div class="card-header">
        <h3 class="card-title"></h3>
    </div> --}}

        <form id="formulario" method="POST" action="">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row mb-2">
                        <label class=" col mr-2">Listar por:</label>
                        <select class=" col mr-2" name="lista" id="lista">
                            <option value=""></option>
                            <option value="0">Nro de orden de ensamble</option>
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
    <div id="modalModificar" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar orden de ensamble</h5>
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
                                    <label class="col-3">Orden de ensamble N°:</label>
                                    <input type="text" id="nroOE" name="nroOE" class="col-2" readonly></input>
                                    <label class="col-2">Fecha:</label>
                                    <input type="text" id="fecha" name="" class="col-2" readonly></input>
                                </div>

                                <div class="row mb-2">
                                    <label class="col-3">Conjunto:</label>
                                    <input type="text" id="conjunto" name="conjunto" class="col-2" readonly></input>
                                    <label class="col-2">Numero:</label>
                                    <input type="text" id="numero" name="numero" class="col-2" readonly></input>
                                </div>


                                <div class="row mb-2">
                                    <label class="col-3">Estado:</label>
                                    <select id="estado" name="estado">
                                        <option value=""></option>
                                        <option value="pendiente">pendiente</option>
                                        <option value="produccion">producción</option>
                                        <option value="finalizado">finalizado</option>
                                    </select>
                                    <label class="col-3">Puesto:</label>
                                    <select id="" name="maquina">
                                        @foreach ($maquinas as $maquina)
                                        <option value="{{$maquina->CodMaquina}}">{{$maquina->NombreMaquina}}</option>
                                            
                                        @endforeach
                                    </select>
                                </div>


                                <div class="row mb-2">
                                </div>
                                
                                
                                
                            </div>
                            
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="guardar" class="btn btn-primary" onclick="">Guardar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@stop
@section('js')
    <script src="{{ asset('js/ensamble-listar.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
