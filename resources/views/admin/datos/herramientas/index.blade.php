@extends('adminlte::page')

@section('title', 'Herramientas')

@section('content_header')
    <a href="{{ route('datos.herramientas.create') }} " class="btn btn-secondary btn-sm float-right">Nueva Herramienta</a>
    <h1>Lista de Herramientas</h1>
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
                    <th>Codigo</th>
                    <th>Herramienta</th>
                    <th>Tipo</th>
                    <th>Inserto</th>
                    <th>Sentido</th>
                    <th>Medida</th>
                    <th>Estado</th>
                    <th>Stock</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($herramientas as $herramienta)
                    <tr>
                        <td>{{ $herramienta->codigo}}</td>
                        <td>{{ $herramienta->descripcion}}</td>
                        <td>{{ $herramienta->tipo}}</td>
                        <td>{{ $herramienta->inserto}}</td>
                        <td>{{ $herramienta->sentido}}</td>
                        <td>{{ $herramienta->medida}}</td>
                        <td>{{ $herramienta->estado}}</td>
                        <td>{{ $herramienta->stock}}</td>
                        <td width="10px"><a href="{{ route('datos.herramientas.edit', $herramienta->id) }}" type="submit"
                                class="btn btn-primary">Editar</a></td>
                        <td width="10px">
                            <form action="{{ route('datos.herramientas.destroy', $herramienta->id) }}" method="POST">
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
