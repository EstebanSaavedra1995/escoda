@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Crear Empleado</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'datos.personal.store']) !!}
            <div class="container">
                <div class="row mb-2">
                    <label class=" col mr-2">Apellido y Nombre :</label>
                    <input type="text" class=" col mr-2" name="nombre">
                    @error('nombre')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Cargo :</label>
                    <select id="" class=" col mr-2" name="cargo">
                        <option value=""></option>
                        @foreach ($cargos as $cargoE)
                            <option value="{{ $cargoE->Cargo }}">{{ $cargoE->Cargo }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Fecha de Ingreso :</label>
                    <input type="date" class=" col mr-2" name="fecha">
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Estado :</label>
                    <select id="" class=" col mr-2" name="estado">
                        <option value=""></option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                    </select>
                </div>

                
            </div>
            {!! Form::submit('Crear Empleado', ['class' => 'btn btn-primary']) !!}
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
