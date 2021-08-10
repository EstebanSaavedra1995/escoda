@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Confeccionar orden de reparación</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>

        <form id="formulario" method="POST" action="">
            @csrf
            <div class="card-body">

                <div class="container">
                    <div class="row mb-2">
                        <label class=" col mr-2">Listar por:</label>
                        <select class=" col mr-2" name="lista" id="lista"></select>
                    </div>

                    <div id="filtro">
                    </div>
                </div>
                <div class="container">
                    <div class="row mb-2">
                        <button type="button" class="btn btn-primary col ">Continuar</button>
                        <button type="button" class="btn btn-danger col ">Cancelar</button>
                    </div>
                </div>

                <div class="container">
                    <div id="divtablatareas" name="divtablatareas">
                    </div>
                </div>

            </div>

        </form>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@stop
@section('js')
    {{-- <script src="{{ asset('js/listarcancelar.js') }}"></script> --}}
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop
