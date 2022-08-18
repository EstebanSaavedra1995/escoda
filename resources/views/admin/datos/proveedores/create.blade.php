@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Crear Proveedor</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {!! Form::open(['route' => 'datos.proveedores.store']) !!}
            <div class="container">
                <div class="row mb-2">
                    <label class=" col mr-2">Nombre de Proveedor :</label>
                    <input type="text" class=" col mr-2" name="nombre" value="" maxlength="50">
                    @error('nombre')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>

                <div class="row mb-2">
                    <label class=" col mr-2">Categoría :</label>
                    <input type="text" class=" col mr-2" name="categoria" value=""
                        maxlength="25">
                    @error('categoria')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror
                </div>
            </div>
            {!! Form::submit('Crear proveedor', ['class' => 'btn btn-primary']) !!}
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
