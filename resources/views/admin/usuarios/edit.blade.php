@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Asignar un Rol</h1>
@stop

@section('content')
    @if (session('info'))
        <div class="alert alert-success">
            <strong>
                {{ session('info') }}
            </strong>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <p class="h5">Nombre:</p>
            <p class="form-control">{{ $user->name }}</p>
            <h2>Listado de Roles</h2>
            {!! Form::model($user, ['route' => ['usuarios.update', $user], 'method' => 'put']) !!}
            @foreach ($roles as $rol)
                <div>
                    <label>
                        {!! Form::checkbox('roles[]', $rol->id, null, ['class' => 'mr-1']) !!}
                        {{ $rol->name }}
                    </label>
                </div>
            @endforeach
            {!! Form::submit('Asignar Rol', ['classs' => 'btn btn-primary mt-2']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
