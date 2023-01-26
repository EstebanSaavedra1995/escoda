@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')

@stop

@section('content')
    @if (session('info'))
        <strong>
            <div class="alert-success">{{ session('info') }}</div>
        </strong>
    @endif

    @if (count($ordenesC) >0 )
    <h3>Ordenes de Construcción</h3>
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
                <td>{{ $orden->NroOC }}</td>
                <td>{{ $orden->Tarea }}</td>
                <td>{{ $orden->NombrePieza }} </td>
                <td>{{ $orden->Renglon }}</td>
                <td>{{ $orden->Cantidad }} </td>
                <td>
                    <form action="{{ route('horarios.maquinas.tiempos') }}" method="POST">
                        <input type="text" name="id" value="{{ $orden->detalleID }}" hidden>
                        @csrf
                        <button type="submit" class="btn btn-primary">Elegir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    @endif

    @if (count($ordenesR) >0 )
    <h3>Ordenes de Reparación</h3>
    <table class="table table-bordered table-striped">
        
        <head>
            <th>Nro. Orden</th>
            <th>Conjunto</th>
            <th>Numero</th>
            <th>Accion</th>
        </head>
        @foreach ($ordenesR as $orden)
        
            <tr>
                <td>{{ $orden->NroOR }}</td>
                <td>{{ $orden->NombrePieza }}</td>
                <td>{{ $orden->NroCjto }}</td>
                <td>
                    <form action="{{ route('horarios.maquinas.tiempos.reparacion') }}" method="POST">
                        <input type="text" name="id" value="{{$orden->NroOR}}" hidden>
                        @csrf
                        <button type="submit" class="btn btn-primary">Elegir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    @endif
    @if (count($ordenesE) >0 )
    <h3>Ordenes de Ensamble</h3>
    <table class="table table-bordered table-striped">

        <head>
            <th>Nro. Orden</th>
            <th>Conjunto</th>
            <th>Numero</th>
            <th>Accion</th>
        </head>
        @foreach ($ordenesE as $orden)
            <tr>
                <td>{{ $orden->NroOE }}</td>
                <td>{{ $orden->NombrePieza }}</td>
                <td>{{ $orden->NroCjto }}</td>
                <td>
                    <form action="{{ route('horarios.maquinas.tiempos.ensamble') }}" method="POST">
                        <input type="text" name="id" value="{{$orden->NroOE}}" hidden>
                        @csrf
                        <button type="submit" class="btn btn-primary">Elegir</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    @endif
@stop

@section('css')
@stop

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @livewireScripts
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ asset('js/cronometro.js') }}"></script>
@stop
