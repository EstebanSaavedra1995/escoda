@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Editar Maquina</h1>
@stop

@section('content')

    @if (session('info'))
        <strong>
            <div class="alert-success">{{ session('info') }}</div>
        </strong>
    @endif
    
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => ['datos.maquinas.update',$maquina->CodMaquina], 'method' => 'put']) !!}
            <div class="container">
                <div class="row mb-2">
                    <label class=" col mr-2">Nombre de Maquina :</label>
                    <input type="text" class=" col mr-2" name="nombreMaquina" value="{{$maquina->NombreMaquina}}" maxlength="30">
                    @error('nombreMaquina')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                
            </div>
            {!! Form::submit('Actualizar Maquina', ['class' => 'btn btn-primary']) !!}
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
