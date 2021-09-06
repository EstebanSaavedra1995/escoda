@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Editar rol</h1>
@stop

@section('content')

    @if (session('info'))
        <strong>
            <div class="alert-success">{{ session('info') }}</div>
        </strong>
    @endif
    <div class="card">
        <div class="card-body">
            {!! Form::model($rol, ['route' => ['roles.update', $rol], 'method' => 'put']) !!}
            @include('admin.roles.partials.form')
            {!! Form::submit('Actualizar Rol', ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@stop

@section('css')
    @livewireStyles
@stop

@section('js')
    @livewireScripts
@stop
