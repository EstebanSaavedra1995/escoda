@extends('adminlte::page')

@section('title', 'Listar Facturas')

@section('content_header')

@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Listar Proveedores</h3>
        </div>
        <div class="card-body">
            <form id="formulario">
                @csrf
                <div class="container">

                    <div class="row mb-2">
                        <label class=" col-2 mr-2">Proveedor:</label>
                        <select name="proveedor" id="proveedor" name="proveedor" class="select2">
                            <option value=""> </option>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor->CodigoProv }}">{{ $proveedor->CodigoProv }} -
                                    {{ $proveedor->NombreProv }} - {{ $proveedor->Categoria }}</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="row mb-2">
                        <label class=" col-2 ">Desde:</label>
                        <input type="date" class="col-2 mr-2" id="desde" name="desde" value="2008-01-01">
                        <label class=" col-2">Hasta:</label>
                        <input type="date" class="col-2 mr-2" id="hasta" name="hasta" value="2022-01-01">
                    </div>
                    <div class="row mb-2">
                        <button class="btn btn-primary" id="listar">Buscar Facturas</button>
                    </div>
                </div>
            </form>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <section class=" connectedSortable ui-sortable">

                            <div class="container">
                                <table class="table table-bordered  table-striped" id="tabla">
                                    <thead>
                                        <tr>
                                            <th>Letra</th>
                                            <th>Nro. de Factura</th>
                                            <th>Fecha</th>
                                            <th>Importe</th>
                                            <th>Observaciones</th>
                                            <th>Valor</th>
                                            <th>Finanzación</th>
                                            <th>Entrega</th>
                                            <th>Calidad</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        </section>

                    </div>
                </div>
            </section>
            <form id="formulario2">
                @csrf
            </form>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">

                        <section class=" connectedSortable ui-sortable">

                            <div class="container">
                                <table class="table table-bordered  table-striped" id="tablaArticulos">
                                    <thead>
                                        <tr>
                                            <th>Codigo de Articulo</th>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Precio Unitario</th>
                                            <th>Observaciones</th>
                                        </tr>
                                    </thead>

                                </table>
                                <div id="btn">
                                    <a href="" class="btn btn-secondary" target="blank">Modificar</a>
                                </div>
                            </div>

                        </section>

                    </div>
                </div>
            </section>
        </div>


    </div>

    {{-- MODAL MODIFICAR FACTURA --}}
    <div id="modalModificar" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar Factura</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-modal">
                        <input type="text" id="fArtId" name="fArtId" readonly>
                        <input type="text" id="pFacId" name="pFacId" readonly hidden>
                        @csrf
                        <div class="row mb-2">
                            <label for="proveedoresMod">proveedor: </label>
                            <select name="proveedoresMod" id="proveedoresMod">
                                @foreach ($proveedores as $item)
                                    <option value="{{ $item->CodigoProv }}">{{ $item->CodigoProv }} -
                                        {{ $item->NombreProv }} - {{ $item->Categoria }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row  mb-2">
                            <label for="provCod">Código: </label>
                            <input type="text" readonly class="col col-2" id="provCod">

                        </div>
                        <div class="row mb-2">
                            <label for="provRazon">Razón Social: </label>
                            <input type="text" readonly class="col col-3" id="provRazon">
                        </div>

                        <div class="row mb-2">
                            <label for="">Factura</label>
                        </div>
                        <div class="row mb-2">
                            <label for="nroFact">Nro. de Factura: </label>
                            <input type="text" readonly class="col" id="nroFact">

                            <label for="tipo">Tipo: </label>
                            <select name="tipo" id="tipo" name="tipo" class="col">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>

                            <label for="iva">IVA: %</label>
                            <select name="iva" id="iva" name="iva" class="col" onchange="bonificacion();">
                                @foreach ($iva as $item)
                                    <option value="{{ $item->IVA }}">{{ $item->IVA }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-2">
                            <label for="fechaMod">Fecha: </label>
                            <input type="date" id="fechaMod" name="fechaMod">
                        </div>

                        <div class="row mb-4">
                            <label for="obsMod">Observaciones: </label>
                            <input type="text" id="obsMod" name="obsMod">
                        </div>
                        <div class="contenedor-tabla-modal">
                            <table class="table table-bordered table-scroll2" id="tablaModal" name="tablaModal">
                                <thead>
                                    <tr>
                                        <th scope="col">Código Articulo</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio Unitario</th>
                                        <th scope="col">Observaciones</th>
                                    </tr>
                                </thead>
                                
                            </table>
                        </div>
                        <div class="row mb-2">
                            <label >Añadir Articulo</label>
                        </div>
                        <div class="row mb-2">
                            <select name="productos" id="productos" class="select2">

                            </select>
                            <div class="col"></div>

                            <label for="subTotal">Sub Total: $ </label>
                            <input type="text" id="subTotal" name="subTotal" readonly>
                        </div>

                        <div class="row mb-2">
                            <label for="bonif">Cantidad : </label>
                            <input type="number" id="cantidad" name="cantidad" class="col" value="1" min="1">

                            <div class="col"></div>
                            <label for="bon">Bonificación:</label>
                            <input type="text" id="bon" readonly>
                        </div>
                        
                        <div class="row mb-2">
                            <label for="bonif">Precio Unitario :</label>
                            <input type="number" id="precioU" name="precioU" class="col">

                            <div class="col"></div>

                            <label for="ivaMod">IVA: $</label>
                            <input type="text" id="ivaMod" readonly>
                        </div>
                        <div class="row mb-3">
                            <label for="bonif">Observaciones :</label>
                            <input type="text" id="observP" name="observP" class="col">
                            <div id="divAñadir" class="col">

                            </div>
                            <div class="col"></div>

                            <label for="total">Total: $</label>
                            <input type="text" id="total" readonly>
                        </div>
                        <div class="row mb-2">
                            <label >Añadir Bonificacion</label>
                        </div>
                        <div class="row mb-2">
                            <label for="bonif">Bonificacion : %</label>
                            <input type="number" id="bonif" name="bonif" class="col">
                            <div id="divBon" class="col">
                                {{-- <button class="btn btn-primary">Aplicar</button> --}}
                            </div>
                            
                            <div class="col"></div>

                        </div>
                        <div class="row mb-2">
                            <label for="">Calificación</label>
                        </div>
                        <div class="row mb-2">

                            <label for="calValor">Valor :</label>
                            <select id="calValor" name="calValor" class="col">
                                <option value="0"></option>
                                <option value="1">Malo</option>
                                <option value="2">Regular</option>
                                <option value="3">Bueno</option>
                            </select>
                            <label for="calFin">Finanzación :</label>
                            <select id="calFin" name="calFin" class="col">
                                <option value="0"></option>
                                <option value="1">Malo</option>
                                <option value="2">Regular</option>
                                <option value="3">Bueno</option>
                            </select>
                            <label for="calEntrega">Entrega :</label>
                            <select id="calEntrega" name="calEntrega" class="col">
                                <option value="0"></option>
                                <option value="1">Malo</option>
                                <option value="2">Regular</option>
                                <option value="3">Bueno</option>
                            </select>
                            <label for="calCalidad">Calidad :</label>
                            <select id="calCalidad" name="calCalidad" class="col">
                                <option value="0"></option>
                                <option value="1">Malo</option>
                                <option value="2">Regular</option>
                                <option value="3">Bueno</option>
                            </select>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="Guardar" onclick="guardarFactura();">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="{{ asset('js/listarFactura.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#proveedor').select2({
                width: '20%'
            });
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('#productos').select2({
                width: '20%'
            });
        });
    </script> --}}
@stop
