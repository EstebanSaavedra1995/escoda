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
                        
{{--                         @foreach ($piezas as $pieza)
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
                                        <button type="button" class="btn btn-primary mb-1">Agregar Material</button>
                                        <button type="button" class="btn btn-primary mb-1">Agregar Goma</button>
                                        <button type="button" class="btn btn-primary mb-1">Agregar Artículos</button>
                                        <button type="button" class="btn btn-primary mb-1">Agregar Piezas</button>
                                        <button type="button" class="btn btn-primary mb-1">Eliminar</button>
                                        <button type="button" class="btn btn-primary mb-1">Borrar Todo</button>
                                        <button type="button" class="btn btn-primary mb-1">Predeterminar</button>
                                        <button type="button" class="btn btn-primary mb-1">Predeterminar</button>
                                        <button type="button" class="btn btn-primary">Exel</button>
                                    </div>
                                    
                                </section>
                        </div>
                    </div>

                </section>
                
            
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
        </div>
    </form>
</div>



@stop

@section('css')
@stop

@section('js')
<script src="{{ asset('js/confeccionarDespiece.js') }}"></script>
@stop
