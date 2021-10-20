@extends('adminlte::page')

@section('title', 'Horarios Maquinas')

@section('content_header')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @livewireScripts
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="{{ asset('js/cronometro.js') }}"></script>
@stop

@section('content')

    @livewire('cronometro')

@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    @livewireStyles
@stop

@section('js')
<script>
    //recibe en js cuando emite el componente lw
    //evento "enviado"

    window.livewire.on('enviado', function() {
        $("#enviado").val('v');
        controlBotones();
        swal("Enviado con exito!", "", "success");
        /*  //mostramos el aviso
         $("#aviso").fadeIn("slow");
         //oculto aviso en 3 seg
         setTimeout(function() {
             $("#aviso").fadeOut("slow");
         }, 3000); */
    });

    window.livewire.on('pausa', function() {
        //swal("Pausa iniciada", "", );
        console.log('pausa');
        localStorage.setItem("pausa", 'v');
        $("#avisoPausa").show();
        motivoPausa();
    });

    window.livewire.on('continuar', function() {
        localStorage.setItem("pausa", 'f');
        $("#avisoPausa").hide();
        swal("Pusa terminada", "", );
        window.livewire.emit('actualizarPausa');
    });
    window.livewire.on('refresh', function() {
        if (localStorage.getItem("pausa") != null & localStorage.getItem("pausa") == 'v') {
        console.log(localStorage.getItem("pausa"));
        $("#avisoPausa").show();
    }
    });

    window.livewire.on('guardado', function(data) {
        localStorage.setItem("idTiempo", document.getElementById('idTiempo').value);
        console.log(data);
    });
</script>

<script>
    if (localStorage.getItem("pausa") != null & localStorage.getItem("pausa") == 'v') {
        console.log(localStorage.getItem("pausa"));
        $("#avisoPausa").show();
    }
</script>
@stop
