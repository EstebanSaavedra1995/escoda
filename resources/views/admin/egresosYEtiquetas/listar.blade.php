@extends('adminlte::page')

@section('title', 'Listar/Modificar/...')

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
                    <select class="form-control col-2 mr-2" name="listarPor" id="listarPor" onchange="collapse();">
                        <option value="0"> </option>
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
                    <label class="col-2" id="cantidadHtas" name="cantidadHtas">Cantidad de Htas.:</label>
                </div>
                {{-- OPCION NRO --}}
                <div class="conteiner collapse" id="collNroEgreso">
                    <div class="row mb-2 ">
                        <label class=" col-2 mr-2">Nro. Egreso:</label>
                        <input type="text" class="form-control col-2 mr-2" id="nroEgreso" name="nroEgreso" value="0">
                    </div>
                </div>
                {{-- OPCION FECHA --}}
                <div class="conteiner  collapse" id="collFecha">
                    <div class="row mb-2">
                        <label class=" col-1">Desde:</label>
                        <input type="date" id="fechaDesde" name="fechaDesde" class="form-control col-3 mr-2"
                            value="2000-01-01" max="{{ $date = date('Y-m-d') }}">
                        <label class=" col-1">Hasta:</label>
                        <input type="date" id="fechaHasta" name="fechaHasta" class="form-control col-3"
                            value="{{ $date = date('Y-m-d') }}" max="{{ $date = date('Y-m-d') }}">
                    </div>
                </div>
                {{-- OPCION PIEZA/CONJ --}}
                <div class="conteiner collapse" id="collPieza">
                    <div class="row mb-2">
                        <div class="form-group col-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ck" id="ck1Mod" value="conjuntos">
                                <label class="form-check-label">Conjuntos</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ck" id="ck2Mod" value="piezas">
                                <label class="form-check-label">Piezas</label>
                            </div>
                        </div>

                        <select class="form-select col-2 mr-1" name="piezasMod" id="piezasMod">
                        </select>

                        <label class=" col ">Nro.</label>
                        <input type="number" class="form-control col" name="nroMod" id="nroMod" value="0" min="0">

                        <label class=" col-1 ">Desde:</label>
                        <input type="date" id="fechaDesdePieza" name="fechaDesdePieza" class="form-control col-2"
                            value="2000-01-01" max="{{ $date = date('Y-m-d') }}">
                        <label class=" col-1 ">Hasta:</label>

                        <input type="date" id="fechaHastaPieza" name="fechaHastaPieza" class="form-control col-2"
                            value="{{ $date = date('Y-m-d') }}" max="{{ $date = date('Y-m-d') }}">

                    </div>
                </div>
                {{-- END OPCIONES --}}


            </div>

            <div class="contenedor-tabla-modal">
                <table class="table table-bordered table-striped table-E" id="tablaMod">
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
                            <th scope="col">Acción</th>
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
        <a href="{{ route('descargarPDF', ['4']) }}" class="btn btn-danger">PDF</a>
        <button class="btn btn-primary" id="btnEtiquetas" onclick="etiqueta();">Etiquetas</button>
    </div>

    {{-- MODAL MODIFICAR --}}
    <div i{{-- MODAL MODIFICAR --}}d="modalModificar" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-modalModificar">

                        @csrf
                        <table class="table table-bordered table-striped">
                            <tbody id="tablamodalmodificartareas">
                                <tr>
                                    <input id="idMod" name="idMod" type="text" value="" class="oculto" readonly hidden>
                                    <td><label for="FechaEgreso">Fecha de Egreso: </label></td>
                                    <td> <input type="date" id="FechaEMod" name="FechaEMod" class="form-control" value=""
                                            max="{{ $date = date('Y-m-d') }}"></td>
                                </tr>
                                <tr>
                                    <td><label for="condicion">Condición: </label></td>
                                    <td><select class="form-select" name="condicionMod" id="condicionMod">
                                            <option value="I">CONDICION I</option>
                                            <option value="II">CONDICION II</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td> <label for="tipoEgreso">Tipo de Egreso: </label> </td>
                                    <td><select class="form-select" name="tipoMod" id="tipoMod">
                                            <option value="EG 2">EG 2</option>
                                            <option value="EG 4">EG 4</option>
                                        </select></td>
                                </tr>
                                <tr>
                                    <td><label for="nroEgreso">Nro. de Egreso: </label></td>
                                    <td> <input type="text" class="form-control" id="nroEMod" name="nroEMod" value=""></td>
                                </tr>
                                <tr>
                                    <td><label for="FechaI">Fecha de Intervención: </label></td>
                                    <td><input type="date" id="FechaIMod" name="FechaIMod" class="form-control" value=""
                                            max="{{ $date = date('Y-m-d') }}"></td>
                                </tr>
                                <tr>
                                    <td><label for="pozo">Pozo: </label></td>
                                    <td><input type="text" class="form-control" id="pozoMod" name="pozoMod"></td>
                                </tr>
                                <tr>
                                    <td><label for="ordenTarea">Orden de Trabajo relacionada: </label></td>
                                    <td><input type="text" class="form-control" name="nroORMod" id="nroORMod"></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="idprueba" value="1">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                        id="btnModificarModal">Modificar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}
    {{-- MODAL ETIQUETAS --}}
    <div id="modalEtiquetas" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Impresión de Etiquetas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="contenedor-tabla-modal" id="tablaEtiqueta">
                        {{-- tabla desde js --}}
                    </div>
                    <input type="hidden" name="idprueba" value="1">
                </div>
                <div class="modal-footer">

                    <form id="formulario-etChicas" method="POST" action="{{ route('etChicasPDF') }}" target="_blank">
                        @csrf
                        <input type="text" hidden id="etiquetasChicas" name="etiquetasChicas">
                        <input type="text" hidden id="tipoChicas" name="tipoChicas">
                        <button type="submit" id="btnEtChicas" class="btn btn-primary">Vista Previa Etiquetas
                            Chicas</button>
                    </form>

                    <form id="formulario-etGrandes" method="POST" action="{{ route('etGrandesPDF') }}" target="_blank">
                        @csrf
                        <input type="text" hidden id="etiquetasGrandes" name="etiquetasGrandes">
                        <input type="text" hidden id="tipoGrandes" name="tipoGrandes">
                        <button type="submit" id="btnEtGrandes" class="btn btn-primary">Vista Previa Etiquetas
                            Grandes</button>
                    </form>


                    <form id="formulario-todo" method="POST" action="{{ route('todoPDF') }}" target="_blank">
                        @csrf
                        <input type="text" hidden id="etChicas" name="etChicas">
                        <input type="text" hidden id="etGrandes" name="etGrandes">
                        <input type="text" hidden id="tipoTodo" name="tipoTodo">
                        <button type="submit" class="btn btn-primary" id="btnTodo">Imprimir Todo</button>
                    </form>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL --}}


@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/listar.js') }}"></script>
    <script>
        $("#cargandoDiv").hide();
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
