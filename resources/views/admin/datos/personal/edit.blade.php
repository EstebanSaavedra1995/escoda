@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Editar Empleado</h1>
@stop

@section('content')

    @if (session('info'))
        <strong>
            <div class="alert-success">{{ session('info') }}</div>
        </strong>
    @endif
    
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => ['datos.personal.update',$empleado->NroLegajo], 'method' => 'put']) !!}
            <div class="container">
                <div class="row mb-2">
                    <label class=" col mr-2">Apellido y Nombre :</label>
                    <input type="text" class=" col mr-2" name="nombre" value="{{$empleado->ApellidoNombre}}">
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
                        @if ($cargoE->Cargo == $empleado->Cargo)
                        <option value="{{ $cargoE->Cargo }}" selected>{{ $cargoE->Cargo }}</option>   
                        @else
                        <option value="{{ $cargoE->Cargo }}">{{ $cargoE->Cargo }}</option>   
                        @endif
                        @endforeach
                    </select>
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Fecha de Ingreso :</label>
                    <input type="date" class=" col mr-2" name="fecha" value="{{$empleado->FechaIngreso}}">
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Estado :</label>
                    <select id="" class=" col mr-2" name="estado">
                        <option value=""></option>
                        @if ($empleado->Estado == 'A')
                        <option value="A" selected>A</option>
                        @else
                        <option value="A">A</option>
                        @endif

                        @if ($empleado->Estado == 'B')
                        <option value="B" selected>B</option>
                        @else
                        <option value="B">B</option>
                        @endif
                        
                    </select>
                </div>

                
            </div>
            {!! Form::submit('Actualizar Empleado', ['class' => 'btn btn-primary']) !!}
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
