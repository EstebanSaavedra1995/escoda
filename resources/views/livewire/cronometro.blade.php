<div class="" align="center">
    <div class="card border-dark" style="max-width: 80%;" align="left">

        <div class="card-header bg-primary">
            <div class="row">
                <h2 class="card-title col">Maquina : </h2>
                <h2 class="card-title col">Usuario : </h2>
            </div>
            <h2 class="card-title col" id="contadorPiezas">Piezas Aptas= {{ $exitosas }}</h2>
            <h2 class="card-title col" id="contadorPiezas">Piezas no Aptas= {{ $fallidas }}</h2>
            <h2 class="card-title col" id="contadorPiezas">Total Piezas = {{ $cantidad }}</h2>
            <input type="text" id="cantidad" wire:model="cantidad" hidden>
            <input type="text" id="tiempo" wire:model="tiempo" hidden>
            <input type="text" id="estado" wire:model="estado" hidden>
            <input type="text" id="exitosas" wire:model="exitosas" hidden>
            <input type="text" id="fallidas" wire:model="fallidas" hidden>
            <input type="text" id="enviado" onchange="" value="v">

        </div>

        <div class="card-body container">


            <div class="row mb-2" align="center">
                <h1 id="screen" class="col mr-2">00:00:00</h1>
            </div>

            <div class="row mb-2">
                <button onclick="start()" class=" btn btn-primary  col" id="start">Comenzar</button>&nbsp;
                <button onclick="stop()" class=" btn btn-primary  col" id="stop">Pausa</button>&nbsp;
                <button onclick="resume()" class=" btn btn-primary  col" id="resume">Continuar</button>&nbsp;
                <button onclick="reset()" class=" btn btn-primary  col " id="reset">Terminar</button>

            </div>
            <div class="row mb-2" align="center">
                <button class="btn btn-primary col-3" wire:click="enviarDatos" id="enviar">Enviar</button>
            </div>

        </div>
        {{-- alert de recibido --}}
        <div style="position:absolute; top:50%; right: 50%;" class="alert alert-success collapse" role="alert"
            id="aviso">
            Enviado</div>
    </div>
    <script>
        controlBotones();
    </script>
    {{-- script que recibe evento para alert --}}
    <script>
        //recibe en js cuando emite el componente lw
        //evento "enviado"
        
        window.livewire.on('enviado', function() {
            controlBotones();
            $("#enviado").val('v');
            //mostramos el aviso
            $("#aviso").fadeIn("slow");
            //oculto aviso en 3 seg
            setTimeout(function() {
                $("#aviso").fadeOut("slow");
            }, 3000);
        });
    </script>
</div>
