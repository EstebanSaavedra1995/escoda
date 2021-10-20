@extends('adminlte::page')

@section('title', 'Egreso')

@section('content_header')

@stop

@section('content')

<div class="card">
    <div class="card-header ">
        @switch($tipo)
            @case(1)
            <h2>Registro de Egresos de Materiales</h2>
                @break
            @case(2)
            <h2>Registro de Egresos de Gomas</h2>
                @break
            @case(3)
            <h2>Registro de Egresos de Artículos</h2>
                @break
            @case(4)
                
            <h2>Registro de Egresos de Piezas</h2>
                @break
            @default
                
        @endswitch
    </div>

    <div class="card-body">
        {{-- <p>Código: {{$pieza->CodPieza}}</p>
        <p>Pieza: {{$pieza->NombrePieza}}</p>
        <p>Medida: {{$pieza->Medida}}</p>
        <p>Stock: {{$pieza->Stock}}</p> --}}
        <h4>Código: {{$pieza->CodPieza}} </h3>
        <h4>Pieza: {{$pieza->NombrePieza}} </h3>
        <h4>Medida: {{$pieza->Medida}} </h3>
        <h4>Stock: {{$pieza->Stock}} </h3>
        <div class="container">
            <div class="row">
                <h4 class="col">Cantidad de Egreso: </h4>
                <input type="number" class="col mr-2" id="cantidad">
                <button class="btn btn-primary" class="col" onclick="calcular()">Calcular</button>
            </div>

            <div class="row mt-2">
                <h4 class="col">Motivo</h4>
                <select name="" id="" class="col">

                </select>
            </div>

            <div class="row mt-5" align="center">
                <h4 class="col">Stock Actual</h4>
                <h4 class="col"></h4>
                <h4 class="col">Egreso</h4>
                <h4 class="col"></h4>
                <h4 class="col">Stock Resultado</h4>
            </div>

            <div class="row " align="center">
                <input class="col" type="number" id="stock" readonly value="{{$pieza->Stock}}">
                <h4 class="col">-</h4>
                <input class="col" type="number" readonly value="" id="egreso">
                <h4 class="col">=</h4>
                <input class="col" type="number" readonly value="" id="resultado">
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
<script src="{{ asset('js/controlStock.js') }}"></script>
@stop
