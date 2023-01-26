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
                        <label class="col-md-2">Listar por:</label>
                        <select name="lista" id="lista" class="form-control col-md-6">
                            <option value="-1">Eliga opción</option>
                            <option value="0">Nro de orden</option>
                            <option value="1">Fecha</option>
                            <option value="2">Pieza</option>
                        </select>
                        <button type="button" id="buscar" name="buscar" disabled="true" onclick="listarOrdenes();"
                            class="btn btn-primary col-4">Listar</button>
                    </div>
                    <div class="row mb-2" id="divOrden" style="display: none">
                        <select name="ordenes" id="ordenes">
                            @foreach ($ordenes as $orden)
                                <option value="{{ $orden->NroOR }}">
                                    {{ $orden->NroOR }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-2" id="divPiezas" style="display: none">
                        <select name="herramienta" id="herramienta">
                            @foreach ($conjuntos as $conjunto)
                                <option value="{{ $conjunto->CodPieza }}">
                                    {{ $conjunto->CodPieza . ' - ' . $conjunto->NombrePieza . ' - ' . $conjunto->Medida }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row mb-2" id="divFechas" style="display: none">
                        <label class="form-label">Desde</label>
                        <input type="date" name="fecha1" id="fecha1" class="form-control">
                        <label class=" form-label">Hasta</label>
                        <input type="date" name="fecha2" id="fecha2" class="form-control">

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
            {{-- <div class="card-body">
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
            </div> --}}
        </form>

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
                                    <input type="text" id="ordenModal" name="ordenModal" class="col-2" readonly></input>
                                    <label class="col-2">Fecha:</label>
                                    <input type="text" id="fecha" name="" class="col-2" readonly></input>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-3">Herramienta:</label>
                                    <input type="text" name="herramientaModal" id="herramientaModal" class="col-2"
                                        readonly></input>

                                        <label class="col-3">Estado:</label>
                                        <select class="col-2 mr-2" name="estadoModal" id="estadoModal">
                                            <option value=""></option>
                                            <option value="pendiente">Pendiente</option>
                                            <option value="produccion">Producción</option>
                                            <option value="finalizado">Finalizado</option>
                                        </select>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-3">Número:</label>
                                    <input type="number" min="1" max="500" class="col-2" id="numero"
                                        name="numero"></input>
                                    <label class="col-3">Maquina:</label>
                                    <select class="col-2 mr-2" name="maquinaModal" id="maquinaModal">
                                        <option value=""></option>
                                        @foreach ($maquinas as $maq)
                                            <option value="{{$maq->CodMaquina}}">{{$maq->NombreMaquina}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-3">Supervisor de trabajo:</label>
                                    <select class="col-2 mr-2" name="supModal" id="supModal">
                                        <option value=""></option>
                                        @foreach ($supervisores as $op)
                                            <option value="{{$op->NroLegajo}}">{{$op->ApellidoNombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row mb-2">
                                    <label class="col-3">Operario:</label>
                                    <select class="col-2 mr-2" name="opModal" id="opModal">
                                        <option value=""></option>
                                        @foreach ($operarios as $op)
                                            <option value="{{$op->NroLegajo}}">{{$op->ApellidoNombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <section class="content">
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
                            </section> --}}
                        </div>
                    </form>
                    <div style="visibility: hidden" id="divNumero" name="divNumero">

                        <form id="formPDF" name="formPDF" method="POST" action="{{ route('ordenRepPDF') }}" target="_blank">
                            @csrf
                            <input type="text" hidden id="idPDF" name="idPDF">
                            <button type="submit"></button>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" 
                        onclick="GuardarOR()">Modificar</button>
                    <button type="button" class="btn btn-danger"  data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/path/to/select2.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

@stop
@section('js')
    <script src="{{ asset('js/reparacion-listar.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#ordenes').select2({
                theme: 'bootstrap4',
                style: 'width: 100%'
            });
            $('#herramienta').select2({
                theme: 'bootstrap4',
                style: 'width: 100%'
            });
        });
    </script>
@stop
