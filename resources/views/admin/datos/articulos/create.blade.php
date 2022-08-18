@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Crear</h1>
@stop

@section('content')
    
@livewire('articulos-create')
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @livewireScripts
    <script>
        window.livewire.on('save', function() {
            swal("Nuevo empleado guardado con exito!", "", "success");
        });
    </script>
@stop
