@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Editar Proveedor</h1>
@stop

@section('content')

    @if (session('info'))
        <strong>
            <div class="alert-success">{{ session('info') }}</div>
        </strong>
    @endif
    
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => ['datos.proveedores.update',$proveedor->CodigoProv], 'method' => 'put']) !!}
            <div class="container">
                <div class="row mb-2">
                    <label class=" col mr-2">Nombre de Proveedor :</label>
                    <input type="text" class=" col mr-2" name="nombre" value="{{$proveedor->NombreProv}}" maxlength="50">
                    @error('nombre')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                
                <div class="row mb-2">
                    <label class=" col mr-2">Categoría :</label>
                    <input type="text" class=" col mr-2" name="categoria" value="{{$proveedor->Categoria}}" maxlength="25">
                    @error('categoria')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
                
            </div>
            {!! Form::submit('Actualizar proveedor', ['class' => 'btn btn-primary']) !!}
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
