@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Lista de piezas y conjuntos</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>

        <form id="formulario" onsubmit="event.preventDefault();">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row mb-2">
                        <input name="buscador" id="buscador" type="text" class="col mr-2"
                            placeholder="Buscar por descripción, codigo de pieza o conjunto y medida">
                        {{-- <label class=" col mr-2">Listar por:</label>
                        <select class=" col mr-2" name="lista" id="lista">
                            <option value="0">Nro de orden</option>
                            <option value="1">Fecha</option>
                            <option value="2">Pieza</option>
                        </select>
                        <button type="button" id="buscar" name="buscar" onclick="listarOrdenes();" disabled
                            class="btn btn-primary col">Listar</button> --}}
                    </div>

                    <div id="filtro"></div>
                </div>
                <div class="container">
                    <div id="divtabla" name="divtabla">
                    </div>
                </div>
                <div class="container">
                    <div id="divtablatareas" name="divtablatareas">
                        <table class="table-striped table table-bordered table-scroll5">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Descripción</th>
                                    <th>Medida</th>
                                    <th>Tipo</th>
                                    <th>Croquis</th>
                                    <th>Instrucción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="tablabody">
                                @foreach ($piezas as $pieza)
                                    <tr>
                                        <td>{{ $pieza->CodPieza }}</td>
                                        <td>{{ $pieza->NombrePieza }}</td>
                                        <td style="width: 30px">{{ $pieza->Medida }}</td>
                                        <td style="width: 30px">Pieza</td>
                                        <td>{{ $pieza->Croquis }}</td>
                                        <td style="width: 30px">{{ $pieza->Instruccion }}</td>
                                        <td><button type="button" onclick="modificarCP('{{$pieza->CodPieza}}', 'pieza');" class="btn btn-info">Modificar</button>
                                                <button type="button" class="btn btn-danger">Eliminar</button></td>
                                    </tr>
                                @endforeach
                                @foreach ($conjuntos as $conjunto)
                                    <tr>
                                        <td>{{ $conjunto->CodPieza }}</td>
                                        <td>{{ $conjunto->NombrePieza }}</td>
                                        <td style="width: 30px">{{ $conjunto->Medida }}</td>
                                        <td style="width: 30px">Conjunto</td>
                                        <td>{{ $conjunto->Croquis }}</td>
                                        <td style="width: 30px">{{ $conjunto->Instruccion }}</td>
                                        <td><button onclick="modificarCP('{{$conjunto->CodPieza}}', 'conjunto');" type="button"
                                                class="btn btn-info">Modificar</button> 
                                                <button type="button" class="btn btn-danger">Eliminar</button></td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success ml-2 mb-2" id="btnAgregar" name="btnAgregar">Agregar</button>
        </form>
        {{-- Modal agregar pc --}}
        <div id="modalAgregarPC" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar pieza o conjunto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formulario2">
                            @csrf
                            <div class="row mb-2">
                                <label class="col-4" for="">Código de pieza:</label>
                                <input id="codigo" name="codigo" class="col-4" type="text" placeholder="Ingrese código">

                            </div>
                            <div class="row mb-2">
                                <label class="col-4" for="">Descripción:</label>
                                <input id="descripcion" name="descripcion" class="col-4" type="text" placeholder="Ingrese descripción">
                                <input id="medida" name="medida" class="col-4" type="text" placeholder="Ingrese medida">

                            </div>
                            <div class="row mb-2">
                                <label for="" class="col-4">Tipo: </label>
                                <select class="col-4" name="tipo" id="tipo">
                                    <option value="Conjunto">Conjunto</option>
                                    <option value="Pieza">Pieza</option>
                                </select>

                            </div>
                            <div class="row mb-2">
                                <label for="" class="col-4">Croquis:</label>
                                <select class="col-4" name="croquis" id="croquis">
                                    <option value="-">-</option>
                                    <option value="A4HV.dwg">A4HV.dwg</option>
                                    <option value="At05 502 Mandril.dwg">At05 502 Mandril.dwg</option>
                                    <option value="At05 503 Camisa Portamordaza.dwg">At05 503 Camisa Portamordaza.dwg</option>
                                    <option value="At05 504 Levas.dwg">At05 504 Levas.dwg</option>
                                    <option value="At05 505 Chaveta.dwg">At05 505 Chaveta.dwg</option>
                                    <option value="At05 507 Tapa.dwg">At05 507 Tapa.dwg</option>
                                    <option value="At05 508 Plato Superior.dwg">At05 508 Plato Superior.dwg</option>
                                    <option value="At05 509 Plato Inferior.dwg">At05 509 Plato Inferior.dwg</option>
                                    <option value="At05 510 Fleje.dwg">At05 510 Fleje.dwg</option>
                                    <option value="EOF 010 Conjunto Armado.dwg">EOF 010 Conjunto Armado.dwg</option>
                                    <option value="EOF 011 Vastago.dwg">EOF 011 Vastago.dwg</option>
                                    <option value="EOF 012 Camisa.dwg">EOF 012 Camisa.dwg</option>
                                    <option value="EOF 013 Jota y Camisa.dwg">EOF 013 Jota y Camisa.dwg</option>
                                    <option value="MOR 506 Mordaza.dwg">MOR 506 Mordaza.dwg</option>
                                    <option value="Tapon Descartable 238.dwg">Tapon Descartable 238.dwg</option>
                                </select>
                            </div>
                            <div class="row mb-2">
                                <label class="col-4" for="">Instrucción:</label>
                                <input id="instruccion" name="instruccion" class="col-4" type="text" placeholder="Ingrese instrucción">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnEnviar" onclick="enviarDatos();">Agregar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalModificarPC" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modificar conjunto o pieza</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formulario3">
                            @csrf
                            <div class="row mb-2">
                                <label class="col-4" for="">Código de pieza:</label>
                                <input  id="codigo2" name="codigo2" class="col-4" type="text" placeholder="Ingrese código" readonly>

                            </div>
                            <div class="row mb-2">
                                <label class="col-4" for="">Descripción:</label>
                                <input id="descripcion2" name="descripcion2" class="col-4" type="text" placeholder="Ingrese descripción">
                                <input id="medida2" name="medida2" class="col-4" type="text" placeholder="Ingrese medida">

                            </div>
                            <div class="row mb-2">
                                <label for="" class="col-4">Tipo: </label>
                                <input type = "text" class="col-4" name="tipo2" id="tipo2" readonly>                           
                            </div>
                            <div class="row mb-2">
                                <label for="" class="col-4">Croquis:</label>
                                <select class="col-4" name="croquis2" id="croquis2">
                                    <option value="-">-</option>
                                    <option value="A4HV.dwg">A4HV.dwg</option>
                                    <option value="At05 502 Mandril.dwg">At05 502 Mandril.dwg</option>
                                    <option value="At05 503 Camisa Portamordaza.dwg">At05 503 Camisa Portamordaza.dwg</option>
                                    <option value="At05 504 Levas.dwg">At05 504 Levas.dwg</option>
                                    <option value="At05 505 Chaveta.dwg">At05 505 Chaveta.dwg</option>
                                    <option value="At05 507 Tapa.dwg">At05 507 Tapa.dwg</option>
                                    <option value="At05 508 Plato Superior.dwg">At05 508 Plato Superior.dwg</option>
                                    <option value="At05 509 Plato Inferior.dwg">At05 509 Plato Inferior.dwg</option>
                                    <option value="At05 510 Fleje.dwg">At05 510 Fleje.dwg</option>
                                    <option value="EOF 010 Conjunto Armado.dwg">EOF 010 Conjunto Armado.dwg</option>
                                    <option value="EOF 011 Vastago.dwg">EOF 011 Vastago.dwg</option>
                                    <option value="EOF 012 Camisa.dwg">EOF 012 Camisa.dwg</option>
                                    <option value="EOF 013 Jota y Camisa.dwg">EOF 013 Jota y Camisa.dwg</option>
                                    <option value="MOR 506 Mordaza.dwg">MOR 506 Mordaza.dwg</option>
                                    <option value="Tapon Descartable 238.dwg">Tapon Descartable 238.dwg</option>
                                </select>
                            </div>
                            <div class="row mb-2">
                                <label class="col-4" for="">Instrucción:</label>
                                <input id="instruccion2" name="instruccion2" class="col-4" type="text" placeholder="Ingrese instrucción">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="actualizar();">Actualizar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
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
    <script src="{{ asset('js/datos-piezaconjunto.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
