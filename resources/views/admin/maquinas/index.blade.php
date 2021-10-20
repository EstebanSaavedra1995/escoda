@extends('adminlte::page')

@section('title', 'Maquinas')

@section('content_header')
@stop

@section('content')

<div class="card">
    <div class="container">
        <div class="row">
            <h1 class="col">Maquina de este equipo</h1>
            <a href="{{ route('maquinas.create') }} " class="btn btn-secondary col-2 mr-2 mt-2">Asignar nueva Maquina</a>

        </div>
    </div>
<div class="card-header">

</div>
    <div class="card-body">
        <div class="container">
            @if ($maquinaDeEquipo != null && $maquinaDeEquipo->CodMaquina != '0')
            <h2 class="col">ID: {{$maquinaDeEquipo->CodMaquina}}</h2>
            <h2 class="col">Nombre: {{$maquinaDeEquipo->NombreMaquina}}</h2>    
                
            @else
            <h2>No Hay Maquina Asignada</h2>
            @endif
        </div>
    </div>
</div>
@stop

@section('css')
@livewireStyles
@stop

@section('js')
@livewireScripts
@stop