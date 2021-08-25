@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')

@stop

@section('content')
{{-- @livewire('usuarioIndex') --}}
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@livewireStyles
@stop

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@livewireScripts
@stop
