@extends('adminlte::page')

@section('title', 'control Maquinas')

@section('content_header')
    {{-- scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @livewireScripts
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
@stop

@section('content')

    @livewire('control-cronometro')
    {{-- <a href="{{ route('control.maquina') }}" class="btn btn-primary col-2" target="_blank">Control</a> --}}

@stop

@section('css')
    @livewireStyles
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@stop
