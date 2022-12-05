@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Editar Herramienta</h1>
@stop

@section('content')

    @if (session('info'))
        <strong>
            <div class="alert-success">{{ session('info') }}</div>
        </strong>
    @endif

    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => ['datos.herramientas.update', $herramienta->id], 'method' => 'put']) !!}
            <div class="container">
                <div class="row mb-2">
                    <label class=" col mr-2">Código :</label>
                    <input type="text" class=" col mr-2" name="codigo" maxlength="12" value="{{ $herramienta->codigo }}">
                    @error('codigo')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Descripción :</label>
                    <input type="text" class=" col mr-2" name="descripcion" maxlength="12"
                        value="{{ $herramienta->descripcion }}">
                    @error('descripcion')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Tipo :</label>
                    <select class=" col mr-2" name="tipo">

                        @if ($herramienta->tipo == 'personal')
                            <option value="personal" selected>personal</option>
                            <option value="maquina">maquina</option>
                        @else
                            <option value="personal">personal</option>
                            <option value="maquina" selected>maquina</option>
                        @endif

                    </select>
                    @error('tipo')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Inserto :</label>
                    <input type="text" class=" col mr-2" name="inserto" maxlength="20"
                        value="{{ $herramienta->inserto }}">
                    @error('inserto')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Sentido :</label>
                    <input type="text" class=" col mr-2" name="sentido" maxlength="12"
                        value="{{ $herramienta->sentido }}">
                    @error('sentido')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Medida :</label>
                    <input type="text" class=" col mr-2" name="medida" maxlength="12"
                        value="{{ $herramienta->medida }}">
                    @error('medida')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                @if ($herramienta->tipo == 'maquina')
                    <div class="row mb-2">
                        <label class=" col mr-2">Estado :</label>
                        <select class=" col mr-2" name="estado">

                            @switch($herramienta->estado)
                                @case('Disponible')
                                    <option value="Disponible" selected>Disponible</option>
                                    <option value="No Disponible">No Disponible</option>
                                    <option value="Rotura">Rotura</option>
                                    <option value="Perdida">Perdida</option>
                                @break

                                @case('No Disponible')
                                    <option value="Disponible">Disponible</option>
                                    <option value="No Disponible" selected>No Disponible</option>
                                    <option value="Rotura">Rotura</option>
                                    <option value="Perdida">Perdida</option>
                                @break

                                @case('Rotura')
                                    <option value="Disponible">Disponible</option>
                                    <option value="No Disponible">No Disponible</option>
                                    <option value="Rotura" selected>Rotura</option>
                                    <option value="Perdida">Perdida</option>
                                @break

                                @case('Perdida')
                                    <option value="Disponible">Disponible</option>
                                    <option value="No Disponible">No Disponible</option>
                                    <option value="Rotura">Rotura</option>
                                    <option value="Perdida" selected>Perdida</option>
                                @break

                                @default
                            @endswitch


                        </select>
                        @error('estado')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                @endif

                @if ($herramienta->tipo == 'personal')
                    <div class="row mb-2">
                        <label class=" col mr-2">Stock :</label>
                        <input type="number" class=" col mr-2" name="stock" min="0"
                            value="{{ $herramienta->stock }}">
                        @error('stock')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                        @enderror
                    </div>
                @endif


            </div>
            {!! Form::submit('Actualizar Herramienta', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

            {{-- @livewire('personal-create') --}}
        </div>
    </div>

@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
