@extends('adminlte::page')

@section('title', 'control de stock')

@section('content_header')

@stop

@section('content')
@livewire('control-stock')

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@livewireStyles
@stop

@section('js')
@livewireScripts
@stop