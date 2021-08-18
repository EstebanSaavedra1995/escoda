@extends('adminlte::page')

@section('title', 'control Maquinas')

@section('content_header')
<div class="container">
    <div class="row">
        <h2 class="col"> </h2>
        <div class="col"></div>
        <div class="col" id="contadorPiezas">
            <h2></h2>
        </div>
        <div></div>

    </div>
</div>
@stop

@section('content')
<div id="pasos">
    <div class="card card-secondary">

        <div class="card-header">
            <h2 class="card-title">Orden de trabajo xxxx </h3>
        </div>

        <div class="card-body">
            <a href="{{ route('tiempos.maquina') }}" class="btn btn-primary col-2" target="_blank" >Tiempos</a>

            {{-- scripts --}}
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
            @livewireScripts
            {{-- scripts --}}
            
           {{--  @livewire("control-horarios")
            @livewire("horarios-lista") --}}


           
        </div>
    </div>
</div>


@stop

@section('css')
@livewireStyles
{{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@stop
