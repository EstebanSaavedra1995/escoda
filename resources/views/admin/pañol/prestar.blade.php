@extends('adminlte::page')

@section('title', 'Pañol')

@section('content_header')

@stop

@section('content')

    <form action="{{ route('panol.prestar.save') }}" method="POST">
        @csrf
        <div class="row mb-2">
            <label for="herramienta" class="col-4">Herramienta:</label>
            <input type="text" readonly id="herramienta" name="herramienta" value="{{ $herramienta->descripcion }}">
            <input type="text" name="idH" id="" value="{{ $herramienta->id }}" hidden>
        </div>

        <div class="row mb-2">
            <label for="operario" class="col-4">Operario:</label>
            <select class="form-control col" name="operario" id="operario" >
                <option value=""></option>
                @foreach ($users as $usr)
                    <option value="{{ $usr->id }}">{{ $usr->NroLegajo }} - {{ $usr->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="row mb-2">
            <label for="maquina" class="col-4">Operario:</label>
            <select class="form-control col" name="maquina" id="maquina">
                <option value=""></option>
                @foreach ($maquina as $mqna)
                    <option value="{{ $mqna->CodMaquina }}">{{ $mqna->NombreMaquina }}</option>
                @endforeach
            </select>
        </div>

        <div class="row mb-2">
            <button class="btn btn-primary" type="submit">Guardar</button>
        </div>

    </form>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    @livewireStyles
@stop
@section('js')
    @livewireScripts
    <script src="{{ asset('js/ensamble-completarcancelar.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            /* $('#ordenes').select2();
            $('#sup').select2();
            $('#op').select2(); */

        });
    </script>
@stop
