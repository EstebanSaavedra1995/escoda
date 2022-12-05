@extends('adminlte::page')

@section('title', 'Pañol')

@section('content_header')

@stop

@section('content')
@livewire('panol')
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@livewireStyles
@stop
@section('js')
@livewireScripts
<script src="{{ asset('js/ensamble-completarcancelar.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            /* $('#ordenes').select2();
            $('#sup').select2();
            $('#op').select2(); */

        });
    </script>
@stop
