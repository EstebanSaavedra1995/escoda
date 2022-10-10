@extends('adminlte::page')

@section('title', 'Lista tareas')

@section('content_header')
@stop

@section('content')

    <div class="card-body container" id="" {{-- style="display:none" --}}>
        {{-- <div class="row">

        <h4 class="col">Piezas Exitosas = {{ $item['exitosas'] }}</h4>
        <h4 class="col">Cantidad a realizar = {{ $item['ordenC']->Cantidad }}</h4>
    </div>

    <div class="row">
        <h4 class="col">Piezas Fallidas = {{ $item['fallidas'] }}</h4>
    </div>

    <div class="row">
        <h4 class="col">Total Piezas = {{ $item['total'] }}</h4>
    </div> --}}

        <table class="table table-striped border-dark">

            <tr class="bg-dark text-light">

                <head>

                    <th>Tipo</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Operario</th>
                </head>
            </tr>
            @foreach ($pausas as $pausa)
            <tr>
                <td>{{$pausa->Tipo}} </td>
                <td>{{$pausa->Inicio}} </td>
                <td>{{$pausa->Fin}} </td>
                <td>{{$pausa->name}} </td>
            </tr>
            @endforeach

        </table>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
