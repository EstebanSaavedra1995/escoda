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
            <div class="card-body">
                <div class="container">
                    <div class="row mb-2">
                        <label class=" col mr-2">Pieza</label>
                        <select class=" col mr-2" name="piezas" id="piezas">
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

                        <button type="button" id="buscar" name="buscar" class="btn btn-primary col ">Buscar
                            materiales</button>
                    </div>
                    <div class="row mb-2">
                        <label class="col mr-1">Longitud de corte (mm)</label>
                        <input type="number" class="form-control col mr-2" id="longcorte" name="longcorte">
                    </div>
                    <div class="row mb-2">
                        <label class="col mr-1">Cantidad necesaria (mts)</label>
                        <input type="number" class="form-control col mr-2" id="cantidad-necesaria"
                            name="cantidad-necesaria">
                    </div>
                    <div class="contenedor-tabla">
                        <table class="table table-bordered table-fixed">
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
                        <table class="table table-bordered">
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
            <button type="button" class="btn btn-primary">Continuar</button>
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
                                    placeholder="Ingrese el codigo del material">
                                <button type="button" id="buscarmodal" name="buscarmodal"
                                    class="btn btn-primary">Buscar</button>
                            </div>
                            <div>
                                <table class="table table-bordered table-scroll1">
                                    <thead>
                                        <tr>
                                            <th scope="col">Codigo</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Sinonimo</th>
                                            <th scope="col">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($materiales as $material)
                                                <td>{{ $material->CodigoMaterial }}</td>
                                                <td>{{ $material->Material }} - {{ $material->Dimension }} -
                                                    {{ $material->Calidad }}</td>
                                                <td>Materiales</td>
                                                <td><button type="button" class="btn btn-info" data-dismiss="modal"
                                                        onclick="agregarMaterial('{{ $material }}');">Agregar</button>
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
                            <div class="row mb-2">
                                <label for="tarea">Tarea: </label>
                                <select class=" col mr-2" name="tarea" id="tarea">
                                    @foreach ($tareas as $tarea)
                                        <option value="{{ $tarea->Tarea }}">
                                            {{ $tarea->Tarea }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mb-2">
                                <label for="maquina">Máquina: </label>
                                <select class=" col mr-2" name="maquina" id="maquina">
                                    @foreach ($maquinas as $maquina)
                                        <option value="{{ $maquina->CodMaquina }}">
                                            {{ $maquina->CodMaquina }} - {{$maquina->NombreMaquina}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mb-2">
                                <label for="operario">Operario: </label>
                                <select class=" col mr-2" name="operario" id="operario">
                                    @foreach ($piezas as $pieza)
                                        <option value="{{ $pieza->CodPieza }}">
                                            {{ $pieza->CodPieza }} -
                                            {{ $pieza->NombrePieza }} -
                                            {{ $pieza->Medida }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row mb-2">
                                <label for="supervisor">Supervisor de área: </label>
                                <select class=" col mr-2" name="supervisor" id="supervisor">
                                    @foreach ($supervisores as $supervisor)
                                        <option value="{{ $supervisor->NroLegajo }}">
                                          {{$supervisor->NroLegajo}} - {{$supervisor->ApellidoNombre}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Agregar</button>
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

    @stop
