@extends('adminlte::page')

@section('title', 'Personal')

@section('content_header')
    <a href="{{ route('datos.personal.create') }} " class="btn btn-secondary btn-sm float-right">Nuevo Empleado</a>
    <h1>Lista de personal</h1>
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
                    <th>Lejago</th>
                    <th>Apellido y Nombre</th>
                    <th>Cargo</th>
                    <th>Fecha de Ingreso</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($personal as $persona)
                    <tr>
                        <td>{{ $persona->NroLegajo}}</td>
                        <td>{{ $persona->ApellidoNombre}}</td>
                        <td>{{ $persona->Cargo}}</td>
                        <td>{{ $persona->FechaIngreso}}</td>
                        <td>{{ $persona->Estado}}</td>
                        <td width="10px"><a href="{{ route('datos.personal.edit', $persona->NroLegajo) }}" type="submit"
                                class="btn btn-primary">Editar</a></td>
                        <td width="10px">
                            <form action="{{ route('datos.personal.destroy', $persona->NroLegajo) }}" method="POST">
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
