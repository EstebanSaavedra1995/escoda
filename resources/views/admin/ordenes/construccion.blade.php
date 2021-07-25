@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Construcción</h1>
@stop

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Confección de orden de construcción N°: {{ $nuevaOC }}</h3>
        </div>

        <form id="formulario" method="POST" action="">
            @csrf
            <input type="hidden" value="{{$nuevaOC}}">
            <div class="card-body">
                <div class="container">
                    <div class="row mb-2">
                        <label class=" col mr-2">Pieza</label>
                        <select class=" col mr-2" name="piezas" id="piezas">
                            <option value="">Seleccione pieza</option>
                            @foreach ($piezas as $pieza)
                                <option value="{{ $pieza->CodPieza }}">
                                    {{ $pieza->CodPieza }} -
                                    {{ $pieza->NombrePieza }} -
                                    {{ $pieza->Medida }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-primary col ">Crokis</button>
                    </div>
                    <div class="row mb-2">
                        <label class=" col mr-2">Cantidad a realizar</label>
                        <input type="number" class="form-control col mr-2" min="0" value="0" id="cantidad-realizar"
                            name="cantidad-realizar">
                        <button type="button" class="btn btn-primary col ">Procedimiento</button>
                    </div>
                </div>
                <div class="container">
                    <div class="row mb-2">
                        <label class=" col mr-2">Material</label>
                        <input type="text" class="form-control col mr-2" id="material" name="material" readonly>
                        <input type="hidden" id="idmaterial" name="idmaterial">

                        <button type="button" id="buscar" name="buscar" class="btn btn-primary col ">Buscar
                            materiales</button>
                    </div>
                    <div class="row mb-2">
                        <label class="col mr-1">Longitud de corte (mm)</label>
                        <input type="number" class="form-control col mr-2" id="longcorte" name="longcorte" readonly>
                    </div>
                    <div class="row mb-2">
                        <label class="col mr-1">Cantidad necesaria (mts)</label>
                        <input type="number" class="form-control col mr-2" id="cantidad-necesaria"
                            name="cantidad-necesaria" readonly >
                    </div>
                    <div class="contenedor-tabla">
                        <table class="table table-striped table-bordered table-scroll1">
                            <thead>
                                <tr>
                                    <th scope="col">Colada</th>
                                    <th scope="col">Stock (mts)</th>
                                </tr>
                            </thead>
                            <tbody id="contenidotabla">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="container">
                    <div>
                        <table class="table-striped table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Tareas</th>
                                    <th scope="col">Máquinas</th>
                                    <th scope="col">Operarios</th>
                                    <th scope="col">Supervisores</th>
                                    <th scope="col">Horas</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tareas">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer">
            </div>
            <button type="button" class="btn btn-primary" id="continuar" name="continuar" onclick="validar();">Continuar</button>
            <button type="button" class="btn btn-danger">Cancelar</button>
        </form>
        {{-- MODAL MATERIALES --}}
        <div id="modal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Lista de materiales</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formulario-modal">
                            @csrf
                            <div class="row mb-2">
                                <input type="text" class="form-control col mr-2" id="buscarmaterial" name="buscarmaterial"
                                    placeholder="Ingrese el codigo del material a buscar">
                                {{-- <button type="button" id="buscarmodal" name="buscarmodal"
                                    class="btn btn-primary">Buscar</button> --}}
                            </div>
                            <div>
                                <table class=" table-striped table table-bordered table-scroll1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Codigo</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Sinonimo</th>
                                            <th scope="col">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodymodal">
                                        <tr>
                                            @foreach ($materiales as $material)
                                                <td>{{ $material->CodigoMaterial }}</td>
                                                <td>{{ $material->Material }} - {{ $material->Dimension }} -
                                                    {{ $material->Calidad }}</td>
                                                <td>Materiales</td>
                                                <td><button type="button" class="btn btn-info" data-dismiss="modal"
                                                        onclick="agregarMaterial('{{ $material->CodigoMaterial }}');">Agregar</button>
                                                </td>
                                        </tr>
                                        @endforeach
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
        {{-- MODAL TAREAS --}}
        <div id="modaltareas" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar tarea</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formulario-modaltarea">
                            @csrf
                            <table class="table table-bordered table-striped">
                                <tbody id="tablamodaltareas">
                                    <tr>
                                        <td><label for="tareaModal">Tarea: </label></td>
                                        <td> <select class=" col mr-2" name="tareaModal" id="tareaModal">
                                                @foreach ($tareas as $tarea)
                                                    <option value="{{ $tarea }}">
                                                        {{ $tarea->Tarea }}
                                                    </option>
                                                @endforeach
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><label for="maquina">Maquina: </label></td>
                                        <td> <select class=" col mr-2" name="maquina" id="maquina">
                                                @foreach ($maquinas as $maquina)
                                                    <option value="{{ $maquina }}">
                                                        {{ $maquina->CodMaquina }} - {{ $maquina->NombreMaquina }}
                                                    </option>
                                                @endforeach
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td> <label for="operario">Operario: </label> </td>

                                        <td> <select class=" col mr-2" name="operario" id="operario">
                                                @foreach ($operarios as $operario)
                                                    <option value="{{ $operario }}">
                                                        {{ $operario->NroLegajo }} - {{ $operario->ApellidoNombre }}
                                                    </option>
                                                @endforeach
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><label for="supervisor">Supervisor de área: </label></td>
                                        <td> <select class=" col mr-2" name="supervisor" id="supervisor">
                                                @foreach ($supervisores as $supervisor)
                                                    <option value="{{ $supervisor }}">
                                                        {{ $supervisor->NroLegajo }} -
                                                        {{ $supervisor->ApellidoNombre }}
                                                    </option>
                                                @endforeach
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><label for="tiempo-agregartarea">Tiempo estimado de la tarea</label></td>
                                        <td><input type="time" min="09:00" step="5" id="horaminuto" name="horaminuto"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                            onclick="agregarTareaModal();">Agregar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- MODAL Modificar TAREAS --}}
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
                            <table class="table table-bordered table-striped">
                                <tbody id="tablamodalmodificartareas">
                                    <tr>
                                        <td><label for="tarea-modificar">Tarea: </label></td>
                                        <td> <select class=" col mr-2" name="tarea-modificar" id="tarea-modificar">
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><label for="maquina-modificar">Maquina: </label></td>
                                        <td> <select class=" col mr-2" name="maquina-modificar" id="maquina-modificar">
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td> <label for="operario-modificar">Operario: </label> </td>
                                        <td> <select class=" col mr-2" name="operario-modificar" id="operario-modificar">
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><label for="supervisor-modificar">Supervisor de área: </label></td>
                                        <td> <select class=" col mr-2" name="supervisor-modificar"
                                                id="supervisor-modificar">
                                            </select></td>
                                    </tr>
                                    <tr>
                                        <td><label for="tiempo-agregartarea">Tiempo estimado de la tarea</label></td>
                                        <td><input type="time" min="09:00" step="5" id="modificarhoraminuto" name="modificarhoraminuto"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <input id="idTareaModificar" name="idTareaModificar" type="hidden">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                            id="idbtnModificarTarea">Modificar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/construccion.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@stop
