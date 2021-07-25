@extends('adminlte::page')

@section('title', 'Registrar Egresos')

@section('content_header')

@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Trazabilidad</h3>
        </div>

        <form id="formulario" method="POST" action="">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row mb-2">

                        <div class="form-group col-2 ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ck" id="ck1" value="conjuntos">
                                <label class="form-check-label">Conjuntos</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ck" id="ck2" value="piezas">
                                <label class="form-check-label">Piezas</label>
                            </div>
                        </div>

                        <select class="form-select col mr-2" name="piezas" id="piezas">
                        </select>

                        <input type="number" class="form-control col-2 mr-2">
                    </div>
                </div>

                <div class="container">
                    {{-- <div class="row mb-2">

                        <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button"
                            aria-expanded="false" aria-controls="collapseExample">
                            Link with href
                        </a>
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Button with data-bs-target
                        </button>
                    </div> --}}
                    {{-- <div class="collapse-show" id="collapseExample">
                        <div class="card card-body"> --}}

                    <div class="row mb-2">
                        <label class=" col-2 mr-2">Fecha de Egreso:</label>
                        <input type="date" id="start" name="trip-start" class="form-control col-4">
                    </div>

                    <div class="row mb-2">
                        <label class=" col-2 mr-2">Condición:</label>
                        <select class="form-select col-2 mr-2" name="" id="">
                            <option value="CONDICION I">CONDICION I</option>
                            <option value="CONDICION II">CONDICION II</option>
                        </select>
                    </div>

                    <div class="row mb-2">
                        <label class=" col-2 mr-2">Tipo de Egreso:</label>
                        <select class="form-select col-2 mr-2" name="" id="">
                            <option value="EG 2">EG 2</option>
                            <option value="EG 4">EG 4</option>
                        </select>
                    </div>

                    <div class="row mb-2">
                        <label class=" col-2 mr-2">Nro. de Egreso:</label>
                        <input type="number" id="" class="col-2 mr-2" min="0">
                    </div>

                    <div class="row mb-2">
                        <label class=" col-2 mr-2">Fecha de Intervención:</label>
                        <input type="date" id="start" name="trip-start" class="form-control col-4">
                    </div>

                    <div class="row mb-2">
                        <label class=" col-2 mr-2">Pozo:</label>
                        <input type="text" class="col-2 mr-2">
                    </div>

                    <div class="row mb-2">
                        <label class=" col-2 mr-2">Orden de Tarea relacionada:</label>
                        <select class="form-select col-2 mr-2" name="" id=""></select>
                    </div>

                    <div class="row mt-4">
                        <button class="btn btn-primary col-2 mr-2" type="button">Guardar</button>
                        <button class="btn btn-primary col-2" type="button" id="listarBtn">Listar</button>
                    </div>


        </form>

        {{-- </div>
                    </div> --}}

        {{-- MODAL LISTAR --}}
        <div id="modalListar" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lista de Egresos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formulario-modal" method="POST">
                            @csrf
                            <div class="conteiner">
                                <div class="row">
                                    <label class="col mb-2">listar por...</label>
                                </div>

                                <div class="row mb-2">
                                    <select class="form-control col-2 mr-2" name="" id="listarPor" onchange="collapse();">
                                        <option value="nroDeEgreso"> </option>
                                        <option value="nroDeEgreso">Nro de Egreso</option>
                                        <option value="fecha">Fecha</option>
                                        <option value="pieza">Pieza/Conjunto</option>
                                    </select>
                                    <button class="btn btn-primary col-2 mr-2" type="button" id="btnListarMod">Listar</button>
                                    {{-- SPINER --}}
                                    <div class="spinner-border text-primary " role="status" id="cargandoDiv">
                                        <span class="visually-hidden"></span>
                                    </div>
                                    
                                    <div class="col-2"></div>
                                    <label class="col-2">Cantidad de Htas.:</label>
                                </div>
                                {{-- OPCION NRO --}}
                                <div class="conteiner collapse" id="collNroEgreso">
                                    <div class="row mb-2 ">
                                        <label class=" col-2 mr-2">Nro. Egreso:</label>
                                        <input type="text" class="form-control col-2 mr-2" id="nroEgreso">
                                    </div>
                                </div>
                                {{-- OPCION FECHA --}}
                                <div class="conteiner  collapse" id="collFecha">
                                    <div class="row mb-2">
                                        <label class=" col-1">Desde:</label>
                                        <input type="date" id="start" name="trip-start" class="form-control col-3 mr-2"
                                            id="fechaDesde">
                                        <label class=" col-1">Hasta:</label>
                                        <input type="date" id="start" name="trip-start" class="form-control col-3"
                                            id="fechaHasta">
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

                                        <select class="form-select col-2 mr-1" name="piezas" id="piezasMod">
                                        </select>
                                        
                                        <label class=" col ">Nro.</label>
                                        <input type="number" class="form-control col">

                                        <label class=" col-1 ">Desde:</label>
                                        <input type="date" id="piezaDesde" name="trip-start" class="form-control col-2"
                                            id="fechaDesde">
                                        <label class=" col-1 ">Hasta:</label>
                                        <input type="date" id="piezaHasta" name="trip-start" class="form-control col-2"
                                            id="fechaHasta">

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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- END MODAL --}}
    </div>

    </div>
    <!-- /.card-body -->


    <div class="card-footer">
        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
    </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@stop

@section('js')
    <script src="{{ asset('js/registrarEgresos.js') }}"></script>
    <script > $("#cargandoDiv").hide();</script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
