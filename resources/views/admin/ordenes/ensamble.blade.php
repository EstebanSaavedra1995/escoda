@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Confeccionar orden de ensamble</h1>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title"></h3>
        </div>
        <form id="formulario" method="POST" action="">
            @csrf
            <input type="hidden" name="noe" id="noe">
            <div class="card-body">
                <div class="container">
                    <div class="row mb-2">
                        <label class=" col mr-2">Listar por:</label>
                        <select class=" col mr-2" name="conjunto" id="conjunto">
                            @foreach ($conjuntos as $conjunto)
                                <option value="{{ $conjunto->CodPieza }}">
                                    {{ $conjunto->CodPieza }} - {{ $conjunto->NombrePieza }} - {{ $conjunto->Medida }}
                                </option>
                                
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="container">
                    <div class="row mb-2">
                        <button type="button" onclick="cargarTabla();" class="btn btn-primary col ">Continuar</button>
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
    <script src="{{ asset('js/ensamble.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@stop

