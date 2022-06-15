@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')

@stop

@section('content')

    @livewire('cronometro', ['id' => $idTarea])

@stop

@section('css')
@livewireStyles
@stop

@section('js')
@livewireScripts
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ asset('js/cronometro.js') }}"></script>
@stop
