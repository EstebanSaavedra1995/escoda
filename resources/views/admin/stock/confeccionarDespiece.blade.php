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

                <div class="row mb-2">
                    <table class="table table-striped" id="tabla">
                        <thead>
                        <tr class="">
                            <td scope="col" class="table-primary">Tipo</td>
                            <td scope="col" class="table-primary">Descripción</td>
                            <td scope="col" class="table-primary">Cantidad</td>
                        </tr>
                        </thead>

                        <tr class="">
                            <td scope="col" class=""></td>
                            <td scope="col" class=""></td>
                            <td scope="col" class=""></td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="container">
                <div class="row mb-2">
                   
  
                </div>
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
<<<<<<< HEAD
    
=======
  {{--   <link rel="stylesheet" href="/css/admin_custom.css"> --}}
>>>>>>> cd4eb8f77466199e6f095eb1c29080132e3d6972
@stop

@section('js')
<script src="{{ asset('js/confeccionarDespiece.js') }}"></script>
@stop
