@extends('adminlte::page')

@section('title', 'Personal')

@section('content_header')
    <a href="{{ route('datos.proveedores.create') }} " class="btn btn-secondary btn-sm float-right">Nuevo Cargo</a>
    <h1>Lista de Proveedores</h1>
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
                    <th>Codigo Proveedor</th>
                    <th>Nombre de Proveedor</th>
                    <th>Categoría</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->CodigoProv}}</td>
                        <td>{{ $proveedor->NombreProv}}</td>
                        <td>{{ $proveedor->Categoria}}</td>
                        <td width="10px"><a href="{{ route('datos.proveedores.edit', $proveedor->CodigoProv) }}" type="submit"
                                class="btn btn-primary">Editar</a></td>
                        <td width="10px">
                            <form action="{{ route('datos.proveedores.destroy', $proveedor->CodigoProv) }}" method="POST">
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
