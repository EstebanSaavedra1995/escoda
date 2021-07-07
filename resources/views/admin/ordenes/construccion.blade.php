@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Construcción</h1>
@stop

@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Confección de orden de construcción N°: {{ $nuevaOC }}</h3>
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
                    <select class=" col mr-2" name="piezas" id="piezas">
                        @foreach ($piezas as $pieza)
                            <option value="{{ $pieza->CodPieza }}">
                                {{ $pieza->CodPieza }} -
                                {{ $pieza->NombrePieza }} -
                                {{ $pieza->Medida }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-secondary col ">Crokis</button>
                </div>
                <div class="row mb-2">
                    <label class=" col mr-2">Cantidad a realizar</label>
                    <input type="number" class="form-control col mr-2" min="0" id="">
                    <button type="button" class="btn btn-secondary col ">Procedimiento</button>
                </div>
            </div>
            <div class="container">
                <div class="row mb-2">
                    <label class=" col mr-2">Material</label>
                    <input type="text" class="form-control col mr-2"
                        placeholder="CodigoMaterial Material Dimension Calidad" id="material" name="material">

                    <button type="button" class="btn btn-secondary col ">Buscar</button>
                </div>
                <div class="row mb-2">
                    <label class="col mr-2">Cantidad a realizar</label>
                    <input type="number" class="form-control col mr-2" id="">
                    <button type="button" class="btn btn-secondary col ">Procedimiento</button>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
        </div>
    </form>
@stop

@section('css')

@stop

@section('js')
      <script src="{{ asset('js/construccion.js') }}"></script>
{{--    <script>
    $("#piezas").change(function() {
        $.ajax({
            url: "/admin/construccion",
            method: "POST",
            data: $("#formulario").serialize()
        }).done(function(res) {
            alert(res);

        })
    });
</script> --}}
@stop