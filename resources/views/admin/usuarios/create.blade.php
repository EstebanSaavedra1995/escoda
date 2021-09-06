@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
<h1>Crear usuario</h1>
@stop

@section('content')
    {!! Form::open(['route' => 'usuarios.store']) !!}
    <div class="form-group">

        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del usuario']) !!}
        @error('name')
            <small class="text-danger">
                {{$message}}
            </small>
        @enderror

        {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el email del usuario']) !!}
        @error('email')
            <small class="text-danger">
                {{$message}}
            </small>
        @enderror

        @livewire('usuarios-password')
    </div>

    <h2 class="h3">Lista de roles</h2>
            @foreach ($roles as $role)
                <div>
                    <label >
                        {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                        {{$role->name}}
                    </label>
                </div>
            @endforeach
    {!! Form::submit('Crear Usuario', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
