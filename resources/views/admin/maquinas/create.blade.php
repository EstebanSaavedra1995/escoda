@extends('adminlte::page')

@section('title', 'Asignar maquina')

@section('content_header')
    <h1>Asignar maquina a este equipo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2>Elija una maquina para asignar a este equipo</h2>
        </div>

        <div class="card-body">
            <label for="">Maquinas</label>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($maquinas as $maquina)
                        <tr>
                            <td>
                                {{ $maquina->CodMaquina }}
                            </td>
                            <td>
                                {{ $maquina->NombreMaquina }}
                            </td>
                            <td>
                                <a type="submit" href="{{ route('maquinas.edit',$maquina->CodMaquina) }}" class="btn btn-primary">Asignar</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
