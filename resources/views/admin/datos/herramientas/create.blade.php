@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Crear Herramienta</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'datos.herramientas.store']) !!}
            <div class="container">
                <div class="row mb-2">
                    <label class=" col mr-2">Código :</label>
                    <input type="text" class=" col mr-2" name="codigo" maxlength="12">
                    @error('codigo')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Descripción :</label>
                    <input type="text" class=" col mr-2" name="descripcion" maxlength="12">
                    @error('descripcion')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Tipo :</label>
                    <select class=" col mr-2" name="tipo" maxlength="12">
                        <option value="personal">personal</option>
                        <option value="maquina">maquina</option>
                    </select>
                    @error('tipo')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Inserto :</label>
                    <input type="text" class=" col mr-2" name="inserto" maxlength="20">
                    @error('inserto')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Sentido :</label>
                    <input type="text" class=" col mr-2" name="sentido" maxlength="12">
                    @error('sentido')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Medida :</label>
                    <input type="text" class=" col mr-2" name="medida" maxlength="12">
                    @error('medida')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                {{-- <div class="row mb-2">
                    <label class=" col mr-2">Estado :</label>
                    <select class=" col mr-2" name="estado">
                        <option value=""></option>
                        <option value="No Disponible" >Disponible</option>
                        <option value="No Disponible">No Disponible</option>
                        <option value="Rotura">Rotura</option>
                        <option value="Perdida">Perdida</option>
                    </select>
                    @error('estado')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div> --}}

                <div class="row mb-2">
                    <label class=" col mr-2">Stock :</label>
                    <input type="number" class=" col mr-2" name="stock" min="1" value="1">
                    @error('stock')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>


            </div>
            {!! Form::submit('Crear Herramienta', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

            {{-- @livewire('personal-create') --}}
        </div>
    </div>

@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @livewireScripts
    <script>
        window.livewire.on('save', function() {
            swal("Nuevo empleado guardado con exito!", "", "success");
        });
    </script>
@stop
