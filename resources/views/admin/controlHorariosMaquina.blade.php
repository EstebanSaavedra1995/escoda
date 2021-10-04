@extends('adminlte::page')

@section('title', 'control Maquinas')

@section('content_header')
    {{-- scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @livewireScripts
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
@stop

@section('content')

{{-- @livewire('orden-construccion') --}}
    @livewire('control-cronometro')
    

@stop

@section('css')
    @livewireStyles
@stop

@section('js')
<script src="{{ asset('js/controlCronometro.js') }}"></script>
@stop
