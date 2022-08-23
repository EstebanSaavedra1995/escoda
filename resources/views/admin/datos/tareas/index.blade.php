@extends('adminlte::page')

@section('title', 'Tareas')

@section('content_header')
    <a href="{{ route('datos.tareas.create') }} " class="btn btn-secondary btn-sm float-right">Nueva Tarea</a>
    <h1>Lista de Tareas</h1>
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
                    <th>Tarea</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($tareas as $tarea)
                    <tr>
                        <td>{{ $tarea->Tarea}}</td>
                        <td width="10px"><a href="{{ route('datos.tareas.edit', $tarea->id) }}" type="submit"
                                class="btn btn-primary">Editar</a></td>
                        <td width="10px">
                            <form action="{{ route('datos.tareas.destroy', $tarea->id) }}" method="POST">
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
