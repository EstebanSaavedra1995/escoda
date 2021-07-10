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
                        
                        {{--  @foreach ($piezas as $pieza)
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
                                <table class="table table-striped" id="tabla">
                                    <thead>
                                    <tr class="">
                                        <td scope="col" class="table-primary">Tipo</td>
                                        <td scope="col" class="table-primary">Descripción</td>
                                        <td scope="col" class="table-primary">Cantidad</td>
                                    </tr>
                                    </thead>
                                </table> 
                            </div>
                            </section>
                            <section class="col-lg-4 connectedSortable ui-sortable">
                                <div class="content btn-group-vertical">
                                    <button type="button" class="btn btn-primary mb-1" id="materialbtn">Agregar Material</button>
                                    <button type="button" class="btn btn-primary mb-1" id="gomabtn">Agregar Goma</button>
                                    <button type="button" class="btn btn-primary mb-1" id="articulosbtn">Agregar Artículos</button>
                                    <button type="button" class="btn btn-primary mb-1" id="piezasbtn">Agregar Piezas</button>
                                    <button type="button" class="btn btn-primary mb-1" id="eliminarbtn">Eliminar</button>
                                    <button type="button" class="btn btn-primary mb-1" id="borrartodobtn">Borrar Todo</button>
                                    <button type="button" class="btn btn-primary mb-1" id="predeterminarbtn">Predeterminar</button>
                                    
                                    <button type="button" class="btn btn-primary" id="">Exel</button>
                                </div>
                                
                            </section>
                    </div>
                </div>

            </section>
                
            
        </div>
        <!-- /.card-body -->


        {{-- MODAL --}}
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
                            <input type="text" class="form-control col mr-2" id="buscarmaterial" name="buscarmaterial"
                                placeholder="Ingrese el codigo del material">
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
                                        @foreach ($gomas as $goma)
                                            <td>{{ $goma->CodigoGoma }}</td>
                                            <td>{{ $goma->DiametroInterior }}</td>
                                            <td>{{ $goma->DiametroExterior }}</td>
                                            <td>{{ $goma->Altura }}</td>
                                            <td>{{ $goma->Stock }}</td>
                                            <td><input type="number" min="1" max="{{$goma->Stock}}" id="cantidad"></td>
                                            
                                            <td><button type="button" class="btn btn-info" data-dismiss="modal" 
                                                onclick="agregarGoma('{{json_encode($goma)}}');">Agregar</button></td>
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
        {{-- MODAL --}}
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
                            <input type="text" class="form-control col mr-2" id="buscarmaterial" name="buscarmaterial"
                                placeholder="Ingrese el codigo del material">
                            <button type="button" id="buscarmodal" name="buscarmodal"
                                class="btn btn-primary">Buscar</button>
                        </div>
                        <div class="contenedor-tabla-modal">
                            <table class="table table-bordered table-scroll2">
                                <thead>
                                    <tr>
                                        <th scope="col">Codigo Goma</th>
                                        <th scope="col">Ø Interno</th>
                                        <th scope="col">Ø Externo</th>
                                        <th scope="col">Altura</th>
                                        <th scope="col">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($gomas as $goma)
                                            <td>{{ $goma->CodigoGoma }}</td>
                                            <td>{{ $goma->DiametroInterior }}</td>
                                            <td>{{ $goma->DiametroExterior }}</td>
                                            <td>{{ $goma->Altura }}</td>
                                            <td>{{ $goma->Stock }}</td>
                                            
                                            <td><button id="addgomabtn" type="button" class="btn btn-info" data-dismiss="modal" 
                                                onclick="agregarMaterial('{{($goma)}}');">Agregar</button></td>
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
        {{-- MODAL --}}
        <div id="modalarticulos" class="modal" tabindex="-1" role="dialog">
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
                        <div class="contenedor-tabla-modal">
                            <table class="table-bordered table-fixed-modal table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Codigo Goma</th>
                                        <th scope="col">Ø Interno</th>
                                        <th scope="col">Ø Externo</th>
                                        <th scope="col">Altura</th>
                                        <th scope="col">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($gomas as $goma)
                                            <td>{{ $goma->CodigoGoma }}</td>
                                            <td>{{ $goma->DiametroInterior }}</td>
                                            <td>{{ $goma->DiametroExterior }}</td>
                                            <td>{{ $goma->Altura }}</td>
                                            <td>{{ $goma->Stock }}</td>
                                            
                                            <td><button type="button" class="btn btn-info" data-dismiss="modal" 
                                                onclick="agregarMaterial('{{$goma}}');">Agregar</button></td>
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
        {{-- MODAL --}}
        <div id="modalpiezas" class="modal" tabindex="-1" role="dialog">
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
                        <div class="contenedor-tabla-modal">
                            <table class="table-bordered table-fixed-modal table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Codigo Goma</th>
                                        <th scope="col">Ø Interno</th>
                                        <th scope="col">Ø Externo</th>
                                        <th scope="col">Altura</th>
                                        <th scope="col">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($gomas as $goma)
                                            <td>{{ $goma->CodigoGoma }}</td>
                                            <td>{{ $goma->DiametroInterior }}</td>
                                            <td>{{ $goma->DiametroExterior }}</td>
                                            <td>{{ $goma->Altura }}</td>
                                            <td>{{ $goma->Stock }}</td>
                                            
                                            <td><button type="button" class="btn btn-info" data-dismiss="modal" 
                                                onclick="agregarMaterial('{{$goma}}');">Agregar</button></td>
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
@stop
