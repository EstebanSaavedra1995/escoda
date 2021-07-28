@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
   
@stop

@section('content')
    



            <div class="card-header">
                <h5 class="card-title">Lista de Egresos</h5>
                
            </div>
            <div class="card-body">
                <form id="formulario-modal" method="POST">
                    @csrf
                    <div class="conteiner">
                        <div class="row">
                            <label class="col mb-2">listar por...</label>
                        </div>

                        <div class="row mb-2">
                            <select class="form-control col-2 mr-2" name="listarPor" id="listarPor"
                                onchange="collapse();">
                                <option value="0"> </option>
                                <option value="nroDeEgreso">Nro de Egreso</option>
                                <option value="fecha">Fecha</option>
                                <option value="pieza">Pieza/Conjunto</option>
                            </select>
                            <button class="btn btn-primary col-2 mr-2" type="button"
                                id="btnListarMod">Listar</button>
                            {{-- SPINER --}}
                            <div class="spinner-border text-primary " role="status" id="cargandoDiv">
                                <span class="visually-hidden"></span>
                            </div>

                            <div class="col-2"></div>
                            <label class="col-2" id="cantidadHtas" name="cantidadHtas">Cantidad de Htas.:</label>
                        </div>
                        {{-- OPCION NRO --}}
                        <div class="conteiner collapse" id="collNroEgreso">
                            <div class="row mb-2 ">
                                <label class=" col-2 mr-2">Nro. Egreso:</label>
                                <input type="text" class="form-control col-2 mr-2" id="nroEgreso" name="nroEgreso">
                            </div>
                        </div>
                        {{-- OPCION FECHA --}}
                        <div class="conteiner  collapse" id="collFecha">
                            <div class="row mb-2">
                                <label class=" col-1">Desde:</label>
                                <input type="date" id="fechaDesde" name="fechaDesde" class="form-control col-3 mr-2"
                                value="2000-01-01" max="{{$date = date('Y-m-d')}}">
                                <label class=" col-1">Hasta:</label>
                                <input type="date" id="fechaHasta" name="fechaHasta" class="form-control col-3"
                                value="{{$date = date('Y-m-d')}}" max="{{$date = date('Y-m-d')}}">
                            </div>
                        </div>
                        {{-- OPCION PIEZA/CONJ --}}
                        <div class="conteiner collapse" id="collPieza">
                            <div class="row mb-2">
                                <div class="form-group col-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ck" id="ck1Mod"
                                            value="conjuntos">
                                        <label class="form-check-label">Conjuntos</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="ck" id="ck2Mod"
                                            value="piezas">
                                        <label class="form-check-label">Piezas</label>
                                    </div>
                                </div>

                                <select class="form-select col-2 mr-1" name="piezasMod" id="piezasMod">
                                </select>

                                <label class=" col ">Nro.</label>
                                <input type="number" class="form-control col" name="nroMod" id="nroMod" value="0"
                                    min="0">

                                <label class=" col-1 ">Desde:</label>
                                <input type="date" id="fechaDesdePieza" name="fechaDesdePieza" class="form-control col-2"
                                    value="2000-01-01" max="{{$date = date('Y-m-d')}}">
                                <label class=" col-1 ">Hasta:</label>
                                
                                <input type="date" id="fechaHastaPieza" name="fechaHastaPieza" class="form-control col-2"
                                value="{{$date = date('Y-m-d')}}" max="{{$date = date('Y-m-d')}}">
                                
                            </div>
                        </div>
                        {{-- END OPCIONES --}}


                    </div>

                    <div class="contenedor-tabla-modal">
                        <table class="table table-bordered table-scroll2" id="tablaMod">
                            <thead>
                                <tr>
                                    <th scope="col">Nro. Egreso</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Pieza</th>
                                    <th scope="col">Nro</th>
                                    <th scope="col">Condición</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Intervención</th>
                                    <th scope="col">Pozo</th>
                                    <th scope="col">Orden Trabajo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
            </div>
       

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')

@stop
