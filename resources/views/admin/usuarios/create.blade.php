@extends('adminlte::page')

@section('title', 'Escoda')

@section('content_header')
    <h1>Crear usuario</h1>
@stop

@section('content')
    {!! Form::open(['route' => 'usuarios.store']) !!}
    <div class="form-group">

        {{-- {!! Form::label('legajo', 'Nombre') !!}
        {!! Form::text('legajo', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del usuario']) !!}
        @error('legajo')
        
            <small class="text-danger">
                {{$message}}
            </small>
        @enderror --}}

        {{-- {!! Form::label('email', 'Email') !!}
        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Ingrese el email del usuario']) !!}
        @error('email')
            <small class="text-danger">
                {{$message}}
            </small>
        @enderror --}}
        
        {!! Form::label('NroLegajo', 'Empleado') !!}
        {!! Form::select('NroLegajo', $personal, '', ['class' => 'form-control col-4', 'placeholder' => 'Seleccione un empleado', 'id' => 'legajo', 'onClick' => 'llenarCampo()']) !!}
        
        {!! Form::label('name', 'Nombre') !!}
        {!! Form::text('name', null, ['class' => 'form-control col-4', 'placeholder' => 'Ingrese el nombre de usuario', 'id' => 'nombre']) !!}
        @error('name')
            <small class="text-danger">
                {{ $message }}
            </small>
        @enderror

        @livewire('usuarios-password')
    </div>

    <h2 class="h3">Lista de roles</h2>
    @foreach ($roles as $role)
        <div>
            <label>
                {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                {{ $role->name }}
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
    <script>
        function llenarCampo() {
            var nombre = document.getElementById('nombre');
            var combo = document.getElementById('legajo');
            
            nombre.value = combo.options[combo.selectedIndex].text;
        }
    </script>
@stop
