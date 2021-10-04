<div class="" align=" center">
    <div class="alert alert-danger" role="alert" id="avisoPausa" style="display: none;">Pausa Iniciada</div>
<div class="card border-dark" style="max-width: 95%;" align="left">

    <div class="card-header bg-primary">
        <div class="row">
            <h3 class="col">Maquina : {{ $maquina->CodMaquina }} {{ $maquina->NombreMaquina }}
            </h3>
            <h3 class="col">Orden c. : {{ $ordenC->NroOC }} </h3>
            <h3 class="col">Usuario : {{ auth()->user()->name }} </h3>
        </div>

        <input type="text" id="cantidad" wire:model="cantidad" hidden>
        <input type="text" id="tiempo" wire:model="tiempo" hidden>
        <input type="text" id="estado" wire:model="estado" hidden>
        <input type="text" id="exitosas" wire:model="exitosas" hidden>
        <input type="text" id="fallidas" wire:model="fallidas" hidden>
        <input type="text" id="idTiempo" wire:model="idTiempoOC">
        <input type="text" id="enviado" onchange="" value="v" hidden>
        <input type="text" id="flagPausa" value="f" hidden>

    </div>

    <div class="card-body container" style="max-width: 95%;">
        <div class="row mb-2">
            <h3 class="col">Cantidad = {{ $ordenC->Cantidad }}</h3>
            <h3 class="col">Longitud de Corte ={{ $ordenC->LongitudCorte }}</h3>
            <h3 class="col">Material = {{ $material->Material }}</h3>
            <h3 class="col">Calidad = {{ $material->Calidad }}</h3>
            <h3 class="col">Colada = {{ $ordenC->Colada }}</h3>
        </div>
        <div class="row mb-2">
            <h3 class="col" style="color:green;">Piezas Aptas= {{ $exitosas }}</h3>
            <h3 class="col" style="color:red;">Piezas no Aptas= {{ $fallidas }}</h3>
            <h3 class="col" style="color:blue;">Total Piezas = {{ $cantidad }}</h3>
        </div>
        <div class="row mb-2" align="center">
            <h1 id="screen" class="col mr-2">00:00:00</h1>
        </div>

        <div class="row mb-2">
            <button onclick="start()" class=" btn btn-primary  col" id="start">Comenzar</button>&nbsp;
            {{-- <button onclick="stop()" class=" btn btn-primary  col" id="stop">Pausa</button>&nbsp; --}}
            <button wire:click="pausa" class=" btn btn-primary  col" id="stop">Pausa</button>&nbsp;
            <button wire:click="continuar" class=" btn btn-primary  col" id="resume">Continuar</button>&nbsp;
            {{-- <button onclick="resume()" class=" btn btn-primary  col" id="resume">Continuar</button>&nbsp; --}}
            <button onclick="reset()" class=" btn btn-primary  col " id="reset">Terminar</button>

        </div>
        <div class="mt-5" align="center">
            <button class="btn btn-success col-3" wire:click="enviarDatos" id="enviar">Enviar</button>
        </div>

    </div>
    {{-- alert de recibido --}}
    {{-- <div style="position:absolute; top:50%; right: 50%;" class="alert alert-success collapse" role="alert"
            id="aviso">
            Enviado</div> --}}
</div>
<script>
    controlBotones();
</script>
<script>
    if (localStorage.getItem("pausa") != null & localStorage.getItem("pausa") == 'v') {
        console.log(localStorage.getItem("pausa"));
        $("#avisoPausa").show();
    }
</script>
{{-- script que recibe evento para alert --}}
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
    });

    window.livewire.on('continuar', function() {
        localStorage.setItem("pausa", 'f');
        $("#avisoPausa").hide();
        swal("Pusa terminada", "", );
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
</div>
