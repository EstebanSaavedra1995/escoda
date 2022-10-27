@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')

@stop

@section('content')
<table class="table table-bordered table-striped">
    <head>
        <th>Nro. Orden</th>
        <th>Tarea</th>
        <th>Descripción</th>
        <th>Renglon</th>
        <th>Cantidad</th>
        <th>Accion</th>
    </head>
    @foreach ($ordenesC as $orden)
    <tr>
        <td>{{$orden->NroOC}}</td>
        <td>{{$orden->Tarea}}</td>
        <td>{{$orden->NombrePieza}} </td>
        <td>{{$orden->Renglon}}</td>
        <td>{{$orden->Cantidad}} </td>
        <td>
            <form action="{{ route('horarios.maquinas.tiempos') }}" method="POST">
                <input type="text" name="id" value="{{$orden->detalleID}}" hidden>
                @csrf
                <button type="submit" class="btn btn-primary">Elegir</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@stop

@section('css')
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @livewireScripts
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ asset('js/cronometro.js') }}"></script>
@stop

