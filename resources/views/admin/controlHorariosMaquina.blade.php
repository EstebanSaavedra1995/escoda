@extends('adminlte::page')

@section('title', 'Horarios Maquinas')

@section('content_header')
<div class="container">
<div class="row">
  <h2 class="col"> </h2>
  <div class="col"></div>
  <div class="col" id="contadorPiezas"> <h2></h2></div>
  <div ></div>
  
</div>
</div>
@stop

@section('content')
<div id="pasos">
    <div class="card card-secondary" >

        <div class="card-header">
        <h2 class="card-title">Orden de trabajo xxxx </h3>
        </div>

        <div class="card-body">
        
            <div class="card card-primary">
                <div class="card-header row">
                    <h2 class="card-title col">Maquina xxxx </h3>
                    <h2 class="card-title col">Total Piezas xxxx </h3>
                </div>
                <div class="card-body container">
                 <div class="row">
                     <div class="col">
                        Usuario = -----                        
                     </div>
                     <div class="col">
                        tiempo = -----
                     </div>

                 </div>
                 <div class="row">
                     <div class="col">
                        Usuario = -----                        
                     </div>
                     <div class="col">
                        tiempo = -----
                     </div>

                 </div>
                 <div class="row">
                     <div class="col">
                        Usuario = -----                        
                     </div>
                     <div class="col">
                        tiempo = -----
                     </div>

                 </div>
                </div>
              </div>
        </div>
    </div>
</div>


@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    
@stop

