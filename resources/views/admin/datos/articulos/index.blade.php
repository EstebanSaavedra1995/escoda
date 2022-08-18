@extends('adminlte::page')

@section('title', 'Personal')

@section('content_header')
    <a href="{{ route('datos.articulos.create') }} " class="btn btn-secondary btn-sm float-right">Nuevo Artículo</a>
    <h1>Lista de Artículos, Gomas y Materiales</h1>
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
                    <th>Descripción</th>
                    <th>Sinónimo</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($gomas as $goma)
                    <tr>
                        <td>{{ $goma->CodigoInterno }}</td>
                        <td>{{ $goma->CodigoGoma }} - {{ $goma->DiametroInterior }} - {{ $goma->DiametroExterior }} -
                            {{ $goma->Altura }}</td>
                        <td>Gomas</td>
                        <td width="10px">{{-- <a href="{{ route('datos.articulos.edit', $goma->id, 'g') }}" type="submit"
                                class="btn btn-primary">Editar</a> --}}
                            <form action="{{ route('datos.articulos.edit', $goma->id) }}" method="Get">
                                @csrf
                                <input type="text" name="tipo" value="g" hidden>
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </form>
                        </td>
                        <td width="10px">
                            <form action="{{ route('datos.articulos.destroy', $goma->id) }}" method="POST">
                                <input type="text" name="tipo" value="g" hidden>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @foreach ($materiales as $material)
                    <tr>
                        <td>{{ $material->CodigoMaterial }}</td>
                        <td>{{ $material->Material }} - {{ $material->Dimension }} - {{ $material->Calidad }}</td>
                        <td>Material</td>
                        <td width="10px">{{-- <a href="{{ route('datos.articulos.edit', $material->id,'m') }}" type="submit"
                                class="btn btn-primary">Editar</a> --}}
                            <form action="{{ route('datos.articulos.edit', $material->id) }}" method="Get">
                                @csrf
                                <input type="text" name="tipo" value="m" hidden>
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </form>
                        </td>
                        <td width="10px">
                            <form action="{{ route('datos.articulos.destroy', $material->id) }}" method="POST">
                                <input type="text" name="tipo" value="m" hidden>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @foreach ($articulos as $articulo)
                    <tr>
                        <td>{{ $articulo->CodArticulo }}</td>
                        <td>{{ $articulo->Descripcion }}</td>
                        <td>Artículos Generales</td>
                        <td width="10px">{{-- <a href="{{ route('datos.articulos.edit', $articulo->id) }}" type="submit"
                                class="btn btn-primary">Editar</a> --}}
                            <form action="{{ route('datos.articulos.edit', $articulo->id) }}" method="Get">
                                @csrf
                                <input type="text" name="tipo" value="a" hidden>
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </form>
                        </td>
                        <td width="10px">
                            <form action="{{ route('datos.articulos.destroy', $articulo->id) }}" method="POST">
                                <input type="text" name="tipo" value="a" hidden>
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
