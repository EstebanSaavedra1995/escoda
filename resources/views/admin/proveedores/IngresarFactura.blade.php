@extends('adminlte::page')

@section('title', 'Modificar Factura')

@section('content_header')

@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Ingresar Factura</h3>
        </div>
        <div class="card-body">

            <div class="content">
                <div class="card-body">
                    <form id="formulario-factura">
                        <input type="text" id="fArtId" name="fArtId" readonly hidden>
                        <input type="text" id="pFacId" name="pFacId" readonly hidden>
                        @csrf
                        <div class="row mb-2">
                            <label for="proveedores" class="col col-1">proveedor: </label>
                            <select name="proveedores" id="proveedores" onchange="cambiarProveedor();" class="select2">
                                <option value=""></option>
                                @foreach ($proveedores as $item)
                                    <option value="{{ $item->CodigoProv }}">{{ $item->CodigoProv }} -
                                        {{ $item->NombreProv }} - {{ $item->Categoria }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row  mb-2">
                            <label for="provCod" class="col col-1">Código: </label>
                            <input type="text" readonly class="col col-2" id="provCod" name="provCod">

                        </div>
                        <div class="row mb-2">
                            <label for="provRazon" class="col col-1">Razón Social: </label>
                            <input type="text" readonly class="col col-3" id="provRazon">
                        </div>

                        <div class="row mb-2">
                            <label for="">Factura</label>
                        </div>
                        <div class="row mb-2">
                            <label for="nroFact" class="col col-1">Nro. de Factura: </label>
                            <input type="text" readonly class="col col-3" id="nroFact" value="9999-90000005">

                            <label for="tipo" class="col col-1">Tipo: </label>
                            <select name="tipo" id="tipo" name="tipo" class="col col-3">
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>

                            <label for="iva" class="col col-1">IVA: %</label>
                            <select name="iva" id="iva" name="iva" class="col col-3" onchange="bonificacion();">
                                @foreach ($iva as $item)
                                    <option value="{{ $item->IVA }}">{{ $item->IVA }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row mb-2">
                            <label for="fechaMod" class="col col-1">Fecha: </label>
                            <input type="date" id="fechaMod" name="fechaMod" value="{{ $date = date('Y-m-d') }}">
                        </div>

                        <div class="row mb-4">
                            <label for="obsMod" class="col col-1">Observaciones: </label>
                            <input type="text" id="obsMod" name="obsMod">
                        </div>
                        <div class="contenedor-tabla-card">
                            <table class="table table-bordered table-scroll2" id="tablacard">
                                <thead>
                                    <tr>
                                        <th scope="col">Código Articulo</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio Unitario</th>
                                        <th scope="col">Observaciones</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="row mb-2">
                            {{-- <button class="btn btn-primary" id="btnAñadirArt" onclick="abrirModal();">Añadir Articulo</button> --}}
                            <input type="button" class="btn btn-primary" value="Añadir Articulo" onclick="abrirModal();">
                        </div>
                        <div class="row mb-2">
                            <div class="col"></div>
                            <div class="col"></div>


                            <label for="subTotal">Sub Total: $ </label>
                            <input type="text" id="subTotal" name="subTotal" readonly>
                        </div>

                        <div class="row mb-2">


                            <div class="col"></div>
                            <div class="col"></div>
                            <label for="bon">Bonificación:</label>
                            <input type="text" id="bon" name="bon" readonly>
                        </div>

                        <div class="row mb-2">

                            <div class="col"></div>
                            <div class="col"></div>

                            <label for="ivaMod">IVA: $</label>
                            <input type="text" id="ivaMod" readonly>
                        </div>
                        <div class="row mb-3">

                            <div class="col"></div>
                            <div id="divAñadir" class="col">

                            </div>
                            <div class="col"></div>

                            <label for="total">Total: $</label>
                            <input type="text" id="total" readonly>
                        </div>
                        <div class="row mb-2">
                            <label>Añadir Bonificacion</label>
                        </div>
                        <div class="row mb-2">
                            <label for="bonif">Bonificacion : %</label>
                            <input type="number" id="bonif" name="bonif" class="col">
                            <div id="divBon" class="col">
                                <input type="button" class="btn btn-primary" value="Aplicar" onclick="bonificacion();">
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
                <div class="card-footer">
                    <input type="button" class="btn btn-primary" value="Guardar" onclick="guardarFactura();">
                </div>
            </div>

        </div>


    </div>
    {{-- MODAL AÑADIR --}}
    <div id="modalAñadirArt" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Añadir Articulo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formulario-añadir">
                        @csrf

                        <div class="row mb-2">
                            <label for="selectArt" class=" col col-3">Seleccionar Artículo:</label>
                            <select name="selectArt" id="selectArt" class="select2">
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="row mb-2">
                            <label for="sinonimoArt" class=" col col-3">Sinónimo:</label>
                            <select name="sinonimoArt" id="sinonimoArt" class="select2">
                                <option value=""></option>
                                <option value="Gomas">Gomas</option>
                                <option value="Articulos">Artículos Generales</option>
                                <option value="Materiales">Materiales</option>
                            </select>
                        </div>

                        <div class="row mb-2">
                            <label for="cantidadArt" class=" col col-3">Cantidad:</label>
                            <input type="number" name="cantidadArt" id="cantidadArt" class="col col-2">
                        </div>

                        <div class="row mb-2">
                            <label for="precioArt" class=" col col-3">Precio Unitario: $</label>
                            <input type="number" name="precioArt" id="precioArt" class="col col-2">
                        </div>

                        <div class="row mb-2">
                            <label for="obsArt" class=" col col-3">Observaciones:</label>
                            <input type="text" name="obsArt" id="obsArt" class="col col-2">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-primary" value="Agregar" onclick="agregarArt();" data-dismiss="modal">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                </div>
            </div>
        </div>
    </div>

    {{-- FIN MODAL --}}


@stop

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="{{ asset('js/IngresarFactura.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#proveedores').select2({
                width: '20%'
            });
        });
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('#selectArt').select2({
                width: '40%'
            });
        });
    </script> --}}
@stop
