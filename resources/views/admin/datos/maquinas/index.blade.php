@extends('adminlte::page')

@section('title', 'Personal')

@section('content_header')
    <a href="{{ route('datos.maquinas.create') }} " class="btn btn-secondary btn-sm float-right">Nueva Maquina</a>
    <h1>Lista de maquinas</h1>
@stop

@section('content')
    @if (session('info'))
        <strong>
            <div class="alert-success">{{ session('info') }}</div>
        </strong>
    @endif
    <div class="card">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Maquina</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($maquinas as $maquina)
                    <tr>
                        <td>{{ $maquina->NombreMaquina}}</td>
                        <td width="10px"><a href="{{ route('datos.maquinas.edit', $maquina->CodMaquina) }}" type="submit"
                                class="btn btn-primary">Editar</a></td>
                        <td width="10px">
                            <form action="{{ route('datos.maquinas.destroy', $maquina->CodMaquina) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
