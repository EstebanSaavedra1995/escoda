@extends('adminlte::page')

@section('title', 'Despiece')

@section('content_header')

@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Predeterminar Despiece para control de Stock</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->

        {{-- <div class="row">
  <div class="col-md-6">.col-md-6</div>
  <div class="col-md-6">.col-md-6</div>
</div> --}}

        <form id="formulario" method="POST" action="">
            @csrf
            <div class="card-body">
                <div class="container">
                    <div class="row mb-2">
                        <label class=" col mr-2">Pieza</label>
                        <select class="form-select col mr-2" name="piezas" id="piezas">

                            {{-- @foreach ($piezas as $pieza)
                            <option value="{{ $pieza->CodPieza }}">
                                {{ $pieza->CodPieza }} -
                                {{ $pieza->NombrePieza }} -
                                {{ $pieza->Medida }}
                            </option>
                        @endforeach --}}
                        </select>
                        <div class="form-group col  ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ck" id="ck1" value="conjuntos">
                                <label class="form-check-label">Conjuntos</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ck" id="ck2" value="piezas">
                                <label class="form-check-label">Piezas</label>
                            </div>

                        </div>
                    </div>
                </div>
                <section class="content">
                    <div class="conteiner-fluid">
                        <div class="row">
                            <section class="col-lg-8 connectedSortable ui-sortable">
                                <div class="conteiner-fluid">
                                    <table class="table table-striped table-hover" id="tabla">
                                        {{-- table table-hover text-nowrap" --}}
                                        <thead>
                                            <tr class="">
                                                <td scope="col" class="table-primary">Tipo</td>
                                                <td scope="col" class="table-primary">Descripción</td>
                                                <td scope="col" class="table-primary">Cantidad</td>
                                                <td scope="col" class="table-primary">Accion</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </section>
                            <section class="col-lg-4 connectedSortable ui-sortable">
                                <div class="content btn-group-vertical">
                                    <button type="button" class="btn btn-primary mb-1" id="materialbtn">Agregar
                                        Material</button>
                                    <button type="button" class="btn btn-primary mb-1" id="gomabtn">Agregar Goma</button>
                                    <button type="button" class="btn btn-primary mb-1" id="articulobtn">Agregar
                                        Artículos</button>
                                    <button type="button" class="btn btn-primary mb-1" id="piezabtn">Agregar Piezas</button>

                                    <button type="button" class="btn btn-primary mb-1" id="borrartodobtn"
                                        onclick="eliminarTodo()">Borrar Todo</button>
                                    <button type="button" class="btn btn-primary mb-1"
                                        id="predeterminarbtn">Predeterminar</button>

                                    <button type="button" class="btn btn-primary" id="">Exel</button>
                                </div>


                            </section>
                        </div>
                    </div>

                </section>


            </div>
            <!-- /.card-body -->


            {{-- MODAL GOMA --}}
            <div id="modalgoma" class="modal" tabindex="-1" role="dialog">
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
                                    <input type="text" class="form-control col mr-2" id="buscarmaterial"
                                        name="buscarmaterial" placeholder="Ingrese el codigo del material">
                                    <button type="button" id="buscarmodal" name="buscarmodal"
                                        class="btn btn-primary">Buscar</button>
                                </div>
                                <div class="contenedor-tabla-modal">
                                    <table class="table table-bordered table-scroll1">
                                        <thead>
                                            <tr>
                                                <th scope="col">Codigo Goma</th>
                                                <th scope="col">Ø Interno</th>
                                                <th scope="col">Ø Externo</th>
                                                <th scope="col">Altura</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <div style="display: none">{{ $i = 0 }}</div>
                                                @foreach ($gomas as $goma)
                                                    <div style="display: none">{{ $i = $i + 1 }}</div>
                                                    <td>{{ $goma->CodigoGoma }}</td>
                                                    <td>{{ $goma->DiametroInterior }}</td>
                                                    <td>{{ $goma->DiametroExterior }}</td>
                                                    <td>{{ $goma->Altura }}</td>
                                                    <td>{{ $goma->Stock }}</td>
                                                    <td><input type="number" min="1" max="{{ $goma->Stock }}"
                                                            id="cantidadGomas{{ $i }}"
                                                            onchange="habilitarAgregar('G',{{ $i }})"></td>

                                                    <td><button id="addBtnG{{ $i }}" type="button"
                                                            class="btn btn-info" data-dismiss="modal"
                                                            onclick="agregarGoma('{{ json_encode($goma) }}','{{ $i }}');"
                                                            disabled="true">Agregar</button></td>
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
            {{-- END MODAL --}}
            {{-- MODAL ARTICULOS --}}
            <div id="modalarticulo" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Lista de artículos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formulario-modal">
                                @csrf
                                <div class="row mb-2">
                                    <input type="text" class="form-control col mr-2" id="buscarmaterial"
                                        name="buscarmaterial" placeholder="Ingrese el codigo del material">
                                    <button type="button" id="buscarmodal" name="buscarmodal"
                                        class="btn btn-primary">Buscar</button>
                                </div>
                                <div class="contenedor-tabla-modal">
                                    <table class="table table-bordered table-scroll2">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <div style="display: none">{{ $i = 0 }}</div>
                                                @foreach ($articulos as $articulo)
                                                    <div style="display: none">{{ $i = $i + 1 }}</div>
                                                    <td>{{ $articulo->CodArticulo }}</td>
                                                    <td>{{ $articulo->Descripcion }}</td>
                                                    <td>{{ $articulo->Stock }}</td>
                                                    <td><input type="number" min="1" max="{{ $articulo->Stock }}"
                                                            id="cantidadArticulos{{ $i }}"
                                                            onchange="habilitarAgregar('A',{{ $i }})"></td>

                                                    <td><button id="addBtnA{{ $i }}" type="button"
                                                            class="btn btn-info" data-dismiss="modal"
                                                            onclick="agregarArticulo('{{ json_encode($articulo) }}','{{ $i }}');"
                                                            disabled="true">Agregar</button></td>
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
            {{-- END MODAL --}}
            {{-- MODAL PIEZAS --}}
            <div id="modalpieza" class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Lista de Piezas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="formulario-modal">
                                @csrf
                                <div class="row mb-2">
                                    <input type="text" class="form-control col mr-2" id="buscarmaterial"
                                        name="buscarmaterial" placeholder="Ingrese el codigo del material">
                                    <button type="button" id="buscarmodal" name="buscarmodal"
                                        class="btn btn-primary">Buscar</button>
                                </div>
                                <div class="contenedor-tabla-modal">
                                    <table class="table table-bordered table-scroll2">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <div style="display: none">{{ $i = 0 }}</div>
                                                @foreach ($piezas as $pieza)
                                                    <div style="display: none">{{ $i = $i + 1 }}</div>
                                                    <td>{{ $pieza->CodPieza }}</td>
                                                    <td>{{ $pieza->NombrePieza }} - {{ $pieza->Medida }}</td>
                                                    <td>{{ $pieza->Stock }}</td>
                                                    <td><input type="number" min="1" max="{{ $pieza->Stock }}"
                                                            id="cantidadPiezas{{ $i }}"
                                                            onchange="habilitarAgregar('P',{{ $i }})"></td>

                                                    <td><button id="addBtnP{{ $i }}" type="button"
                                                            class="btn btn-info" data-dismiss="modal"
                                                            onclick="agregarPieza('{{ json_encode($pieza) }}','{{ $i }}');"
                                                            disabled="true">Agregar</button></td>
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
            {{-- END MODAL --}}
            {{-- MODAL MATERIAL --}}
            <div id="modalmaterial" class="modal" tabindex="-1" role="dialog">
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
                                    <input type="text" class="form-control col mr-2" id="buscarmaterial"
                                        name="buscarmaterial" placeholder="Ingrese el codigo del material">
                                    <button type="button" id="buscarmodal" name="buscarmodal"
                                        class="btn btn-primary">Buscar</button>
                                </div>
                                <div class="contenedor-tabla-modal">
                                    <table class="table table-bordered table-scroll2">
                                        <thead>
                                            <tr>
                                                <th scope="col">Código</th>
                                                <th scope="col">Descripción</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <div style="display: none">{{ $i = 0 }}</div>
                                                @foreach ($materiales as $material)
                                                    <div style="display: none">{{ $i = $i + 1 }}</div>
                                                    <td>{{ $material->CodigoMaterial }}</td>
                                                    <td>{{ $material->Material }}</td>
                                                    <td>{{ $material->Stock }}</td>
                                                    <td><input type="number" min="1" max="{{ $material->Stock }}"
                                                            id="cantidadMaterial{{ $i }}"
                                                            onchange="habilitarAgregar('M',{{ $i }})"></td>

                                                    <td><button id="addBtnM{{ $i }}" type="button"
                                                            class="btn btn-info" data-dismiss="modal"
                                                            onclick="agregaMaterial('{{ $material }}','{{ $i }}');"
                                                            disabled="true">Agregar</button></td>
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
            {{-- END MODAL --}}
            {{-- MODAL AGREGAR --}}
            {{-- <div id="modalAgregar" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formulario-modal">
                            @csrf
                        <div class="row mb-2">
                        <label class="col mr-1">Tipo</label>
                        <p class="col mr-1" id="tipoAgregar"></p>      
                        </div>

                        <div class="row mb-2">
                        <label class="col mr-1">Descripción</label>
                        <p class="col mr-1" id="descripcionAgregar"></p>
                        </div>

                        <div class="row mb-2">
                        <label class="col mr-1">Cantidad</label>    
                        <input type="number" min="1" max="" id="cantidadAgregar" onchange="habilitarAgregar()">   
                        </div>
                        <div class="row mb-2">
                            <button id="agregarFinal" type="button" class="btn btn-info" data-dismiss="modal" 
                            onclick="" disabled="">Agregar</button>
                        </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                    </div>
                </div>
            </div>
        </div> --}}
            {{-- END MODAL --}}

            <div class="card-footer">
                {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
            </div>
        </form>
    </div>



@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/confeccionarDespiece.js') }}"></script>
    <script>
        habilitarBotones('vacio');
    </script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
