@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <a href="{{ route('usuarios.create') }} " class="btn btn-secondary btn-sm float-right">Nuevo Usuario</a>
    <h1>Lista de Usuarios</h1>
@stop

@section('content')

    @if (session('info'))
        <strong>
            <div class="alert-success">{{ session('info') }}</div>
        </strong>
    @endif

    @livewire('usuarios-index')

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    @livewireStyles
@stop

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    @livewireScripts
@stop
