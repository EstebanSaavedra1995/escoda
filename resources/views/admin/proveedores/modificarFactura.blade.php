@extends('adminlte::page')

@section('title', 'Modificar Factura')

@section('content_header')

@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Listar Proveedores</h3>
        </div>
        <div class="card-body">
            <form id="formulario-modal">
                @csrf
                <div class="row mb-2">
                    <label for="proveedoresMod">proveedor: </label>
                    <select name="proveedoresMod" id="proveedoresMod">
                        <option value=""></option>
                    </select>
                </div>
                <div class="row ">
                    <label for="provCod">Código: </label>
                    <label id="provCod"></label>
                    
                </div>
                <div class="row mb-2">
                    <label for="provRazon">Razón Social: </label>
                    <label id="provRazon"></label>
                </div>

                <div class="row mb-2">
                    <label for="">Factura</label>
                </div>
                <div class="row">
                    <label for="nroFact">Nro. de Factura: </label>
                    <label id="nroFact" class="col"></label>

                    <label for="tipo">Tipo: </label>
                    <select name="tipo" id="tipo" class="col">
                        <option value=""></option>
                    </select>
                    
                    <label for="iva">IVA: %</label>
                    <select name="iva" id="iva" class="col">
                        <option value=""></option>
                    </select>
                </div>

                <div class="row">
                    <label for="fechaMod">Fecha: </label>
                    <input type="date" id="fechaMod">
                </div>

                <div class="row mb-4">
                    <label for="obsMod">Observaciones: </label>
                    <input type="text" id="obsMod">
                </div>
                <div class="contenedor-tabla-modal">
                    <table class="table table-bordered table-scroll2" id="tablaModal">
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
                        <tbody>
                            <tr>
                               {{--  <div style="display: none">{{ $i = 0 }}</div>
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
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </form>
        </div>


    </div>

@stop

@section('css')
@stop

@section('js')
    <script src="{{ asset('js/listarFactura.js') }}"></script>
    <script>
    </script>
@stop
