@extends('adminlte::page')

@section('title', 'Escoda')

@switch($tipo)
    @case('a')
        @section('content_header')
            <h1>Editar Artículo</h1>
        @stop

        @section('content')

            @if (session('info'))
                <strong>
                    <div class="alert-success">{{ session('info') }}</div>
                </strong>
            @endif

            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['datos.articulos.update', $articulo->id], 'method' => 'put']) !!}
                    <div class="container">
                        <input type="text" name="tipo" value="a" hidden>
                        <div class="row mb-2">
                            <label class=" col mr-2">Codigo de Artículo :</label>
                            <input type="text" class=" col mr-2" name="codigo" value="{{ $articulo->CodArticulo }}" maxlength="15">
                            @error('codigo')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Descripcion :</label>
                            <input type="text" class=" col mr-2" name="descripcion" value="{{ $articulo->Descripcion }}"
                                maxlength="50">
                            @error('descripcion')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Stock :</label>
                            <input type="number" class=" col mr-2" name="stock" value="{{ $articulo->Stock }}">
                            @error('stock')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                    </div>
                    {!! Form::submit('Actualizar Artículo', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}

                    {{-- @livewire('personal-create') --}}
                </div>
            </div>

        @stop
    @break

    @case('g')
        @section('content_header')
            <h1>Editar Goma</h1>
        @stop

        @section('content')

            @if (session('info'))
                <strong>
                    <div class="alert-success">{{ session('info') }}</div>
                </strong>
            @endif

            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['datos.articulos.update', $articulo->id], 'method' => 'put']) !!}
                    <div class="container">
                        <input type="text" name="tipo" value="g" hidden>
                        <div class="row mb-2">
                            <label class=" col mr-2">Codigo Interno :</label>
                            <input type="text" class=" col mr-2" name="codInterno" value="{{ $articulo->CodigoInterno }}"
                                maxlength="15">
                            @error('codInterno')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Diametro Interior :</label>
                            <input type="number" class=" col mr-2" name="diaInt" value="{{ $articulo->DiametroInterior }}">
                            @error('diaInt')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Diametro Exterior :</label>
                            <input type="number" class=" col mr-2" name="diaExt" value="{{ $articulo->DiametroExterior }}">
                            @error('diaExt')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Altura :</label>
                            <input type="number" class=" col mr-2" name="altura" value="{{ $articulo->Altura }}">
                            @error('altura')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Stock :</label>
                            <input type="number" class=" col mr-2" name="stock" value="{{ $articulo->Stock }}">
                            @error('stock')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Codigo de Goma :</label>
                            <input type="text" class=" col mr-2" name="codGoma" value="{{ $articulo->CodigoGoma }}"
                                maxlength="25">
                            @error('codGoma')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                    </div>
                    {!! Form::submit('Actualizar Goma', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}

                </div>
            </div>


        @stop
    @break

    @case('m')
        @section('content_header')
            <h1>Editar Material</h1>
        @stop

        @section('content')

            @if (session('info'))
                <strong>
                    <div class="alert-success">{{ session('info') }}</div>
                </strong>
            @endif

            <div class="card">
                <div class="card-body">
                    {!! Form::open(['route' => ['datos.articulos.update', $articulo->id], 'method' => 'put']) !!}
                    <div class="container">
                        <input type="text" name="tipo" value="m" hidden>
                        <div class="row mb-2">
                            <label class=" col mr-2">Codigo de Material :</label>
                            <input type="text" class=" col mr-2" name="codigo" value="{{ $articulo->CodigoMaterial }}" maxlength="50">
                            @error('codigo')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        
                        <div class="row mb-2">
                            <label class=" col mr-2">Material :</label>
                            <input type="text" class=" col mr-2" name="material" value="{{ $articulo->Material }}" maxlength="20">
                            @error('material')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Dimension :</label>
                            <input type="text" class=" col mr-2" name="dim" value="{{ $articulo->Dimension }}" maxlength="10">
                            @error('dim')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Calidad :</label>
                            <input type="text" class=" col mr-2" name="calidad" value="{{ $articulo->Calidad }}" maxlength="10">
                            @error('calidad')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Stock :</label>
                            <input type="number" class=" col mr-2" name="stock" value="{{ $articulo->Stock }}">
                            @error('stock')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <label class=" col mr-2">Stock Maximo :</label>
                            <input type="number" class=" col mr-2" name="stockMax" value="{{ $articulo->StockMaximo }}">
                            @error('stockMax')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>


                    </div>
                    {!! Form::submit('Actualizar Material', ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}

                </div>
            </div>


        @stop
    @break

    @default
@endswitch


@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
