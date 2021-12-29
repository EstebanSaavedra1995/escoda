@extends('adminlte::page')

@section('title', 'Listar Facturas')

@section('content_header')

@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Listar Proveedores</h3>
    </div>

    <form id="formulario">
        @csrf
        <div class="card-body">
            <div class="container">

                <div class="row mb-2">
                    <label class=" col-2 mr-2">Proveedor:</label>
                    <select name="" id="proveedor" class="form-select">
                        <option value="codigo">Código</option>
                        <option value="descripcion">Descripción</option>
                        <option value="sinonimo">Sinonimo</option>
                    </select>
                </div>
                <div class="row mb-2">
                    <label class=" col-2 ">Desde:</label>
                    <input type="date" class="col-2 mr-2" id="desde">
                    <label class=" col-2">Hasta:</label>
                    <input type="date" class="col-2 mr-2" id="hasta">
                </div>
                <div class="row mb-2">
                    <button class="btn btn-primary" id="listar">Buscar Facturas</button>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        
                        <section class=" connectedSortable ui-sortable">

                            <div class="container">
                                <table class="table table-bordered  table-striped" id="tablaArticulos">
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
                                            <th>Acción</th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        </section>

                    </div>
                </div>
            </section>

    </form>

</div>
@stop

@section('css')
@stop

@section('js')
    <script src="{{ asset('js/listarArticulos.js') }}"></script>
@stop