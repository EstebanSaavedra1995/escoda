@extends('adminlte::page')

@section('title', 'Registrar Egresos')

@section('content_header')
   
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Trazabilidad</h3>
    </div>

    <form id="formulario" method="POST" action="">
        @csrf
        <div class="card-body">
            <div class="container">
                <div class="row mb-2">
                    
                    <div class="form-group col-2 ">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="ck" id="ck1" value="conjuntos">
                          <label class="form-check-label">Conjuntos</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="ck" id="ck2" value="piezas">
                          <label class="form-check-label">Piezas</label>
                        </div>
                    </div>

                    <select class="form-select col mr-2" name="piezas" id="piezas">
                    </select>

                    <input type="number" class="form-control col-2 mr-2">
                </div>
            </div>

            <div class="container">
                <div class="row mb-2">
                    
                </div>
            </div>
            
        </div>
        <!-- /.card-body -->

       
        <div class="card-footer">
            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
        </div>
    </form>
</div>
@stop

@section('css')
   {{--  <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
<script src="{{ asset('js/registrarEgresos.js') }}"></script>
@stop