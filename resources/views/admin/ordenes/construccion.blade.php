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
                    <input type="number" class="form-control col mr-2" min="0" id="" value="0">
                    <button type="button" class="btn btn-secondary col ">Procedimiento</button>
                </div>
            </div>
            <div class="container">
                <div class="row mb-2">
                    <label class=" col mr-2">Material</label>
                    <input type="text" class="form-control col mr-2"
                         id="material" name="material" readonly>

                    <button type="button" id="buscar" name="buscar" class="btn btn-secondary col ">Buscar</button>
                </div>
                <div class="row mb-2">
                    <label class="col mr-1">Longitud de corte (mm)</label>
                    <input type="number" class="form-control col mr-2" id="longcorte" name="longcorte">
                </div>
                <div class="row mb-2">
                    <label class="col mr-1">Cantidad necesaria (mts)</label>
                    <input type="number" class="form-control col mr-2" id="">
                </div>
                <div class="scrollspy-example">
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                          <tr>
                            <th scope="col">Colada</th>
                            <th scope="col">Stock (mts)</th>
                          </tr>
                        </thead>
                        <tbody id="contenidotabla">
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">
            {{-- <button type="submit" class="btn btn-primary">Submit</button> --}}
        </div>
    </form>

    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Modal body text goes here.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

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