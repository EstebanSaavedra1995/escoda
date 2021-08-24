@extends('adminlte::page')

@section('title', 'Escoda')

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

                        <label class=" col-2 mr-2">Buscar por:</label>
                        <input type="text" name="buscar" id="buscar" class="col-2 mr-2">
                        <select name="buscarPor" id="buscarPor" class="form-select">
                            <option value="codigo">Código</option>
                            <option value="denominacion">Denominación</option>
                            <option value="categoria">Categoría</option>
                        </select>

                        <label class=" col-2 mr-2">Calificar por:</label>

                        <div class="form-group col-2 ">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ck" id="ck1" value="factura">
                                <label class="form-check-label">Última Factura</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="ck" id="ck2" value="periodo">
                                <label class="form-check-label">Periodo</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <button class="btn btn-primary" id="listar">Listar</button>
                    </div>
                </div>
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">

                            <section class="col-lg-8 connectedSortable ui-sortable">

                                <div class="container-flex">
                                    <label class="">Proveedores</label>
                                    <table class="table table-bordered table-striped" id="tabla">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Denominación</th>
                                                <th>Categoría</th>
                                                <th>Gral.</th>
                                                <th>Valor</th>
                                                <th>Finanzación</th>
                                                <th>Entrega</th>
                                                <th>Calidad</th>
                                            </tr>
                                        </thead>

                                    </table>
                                </div>

                            </section>
                            <section class="col-lg-4 connectedSortable ui-sortable">

                                <div class="container">
                                    <label class="">Artículos,Materiales,Gomas</label>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Descripción</th>
                                                <th>Sinónimo</th>
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

    </div>
    <!-- /.card-body -->


    <div class="card-footer">
        {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
    </div>
@stop

@section('css')
@stop

@section('js')
    <script src="{{ asset('js/listarProveedores.js') }}"></script>
@stop
