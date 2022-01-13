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
            <input type="hidden" id="hdOC" name="hdOC">
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <label class="col-md-2">Listar por:</label>
                        <select name="lista" id="lista" class="form-control col-md-10">
                            <option value="-1">Eliga opción</option>
                            <option value="0">Nro de orden</option>
                            <option value="1">Fecha</option>
                            <option value="2">Pieza</option>
                        </select>
                        <button type="button" id="buscar" name="buscar" disabled="true" onclick="listarOrdenes();"
                            class="btn btn-primary col-12">Listar</button>
                    </div>
                    <div id="divOrden" style="display: none" class="row">
                        <label class="col-md-12">Orden: </label>
                        <select name="ordenes" id="ordenes">
                            @foreach ($ordenes as $orden)
                                <option value="{{ $orden->id }}">
                                    {{ $orden->NroOC }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="divPiezas" style="display: none" class="row">
                        <select name="pieza" id="pieza">
                            @foreach ($piezas as $pieza)
                                <option value="{{ $pieza->CodPieza }}">
                                    {{ $pieza->CodPieza . ' - ' . $pieza->NombrePieza . ' - ' . $pieza->Medida }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="divFechas" style="display: none" class="row">
                        <label>Desde</label>
                        <input type="date" name="fecha1" id="fecha1">
                        <label>Hasta</label>
                        <input type="date" name="fecha2" id="fecha2">
                    </div>


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
        <div style="visibility: hidden" id="divNumero" name="divNumero">

            <form id="formPDF" name="formPDF" method="POST" action="{{ route('ordenPDF') }}" target="_blank">
                @csrf
                <input type="text" hidden id="idPDF" name="idPDF">
                <button type="submit"></button>
            </form>
        </div>
    </div>

    <div id="modalmodificartareas" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar tarea</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-modalmodificartareas">
                        @csrf
                        <input type="hidden" id="hdDetalle" name="hdDetalle">
                    </form>
                        <table class="table table-bordered table-striped">
                            <tbody id="tablamodalmodificartareas">
                                <tr>
                                    <td><label for="tarea-modificar">Tarea: </label></td>
                                    <td> <select style="width: 100%" class=" col" name="tarea-modificar"
                                            id="tarea-modificar">
                                            @foreach ($tareas as $tarea)
                                            <option value="{{ $tarea->id }}">
                                                {{ $tarea->Tarea }}
                                            </option>
                                            @endforeach
                                        </select>     
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="maquina-modificar">Maquina: </label></td>
                                    <td> <select style="width: 100%" class=" col" name="maquina-modificar"
                                            id="maquina-modificar">
                                            @foreach ($maquinas as $maquina)
                                            <option value="{{ $maquina->CodMaquina }}">
                                                {{ $maquina->CodMaquina . " - " . $maquina->NombreMaquina }}
                                            </option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <td> <label for="operario-modificar">Operario: </label> </td>
                                    <td> <select style="width: 100%" class=" col" name="operario-modificar"
                                            id="operario-modificar">
                                            @foreach ($operarios as $operario)
                                            <option value="{{ $operario->NroLegajo }}">
                                                {{ $operario->NroLegajo . " - " .  $operario->ApellidoNombre }}
                                            </option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <td><label for="supervisor-modificar">Supervisor de área: </label></td>
                                    <td> <select style="width: 100%" class=" col" name="supervisor-modificar"
                                            id="supervisor-modificar">
                                            @foreach ($supervisores as $supervisor)
                                            <option value="{{ $supervisor->NroLegajo }}">
                                                {{$supervisor->NroLegajo . " - " .  $supervisor->ApellidoNombre }}
                                            </option>
                                            @endforeach
                                        </select></td>
                                </tr>
                                <tr>
                                    <td><label for="tiempo-agregartarea">Tiempo estimado de la tarea</label></td>
                                    <td><input type="text" placeholder="03:45" id="modificarhoraminuto"
                                            name="modificarhoraminuto" minlength="5" maxlength="5" size="5"></td>
                                    {{-- <td><input type="time" min="09:00" step="5" id="modificarhoraminuto" name="modificarhoraminuto"></td> --}}
                                </tr>
                            </tbody>
                        </table>
                        <input id="idTareaModificar" name="idTareaModificar" type="hidden">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                        id="idbtnModificarTarea" onclick="enviarModificacion();">Modificar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <style>
        .select2 {
            width: 100% !important;
        }

    </style>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
@stop
@section('js')
    <script src="{{ asset('js/listarcancelar.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#ordenes').select2({
                theme: 'bootstrap4'
            });
            $('#pieza').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@stop
