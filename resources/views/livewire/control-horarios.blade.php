<div>
    <div class="input-group input-group-lg">

        <span class="input-group-text" id="inputGroup-sizing-lg">msj</span>

        <input id="msj" wire:model="prueba" type="text" class="form-control" aria-label="Sizing example input"
            aria-describedby="inputGroup-sizing-lg">

        {{-- controla error de validacion // video4 --}}
        @error('prueba')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    
    <button class="btn btn-primary" wire:click="enviar">Enviar</button>

    {{-- alert de recibido --}}
    <div style="position:absolute; top:50%; right: 50%;" class="alert alert-success collapse" role="alert" id="aviso">
        Enviado</div>
     {{-- script que recibe evento para alert --}}   
    <script>
        //recibe en js cuando emite el componente lw
        //evento "enviado"
        window.livewire.on('enviado', function() {
            //mostramos el aviso
            $("#aviso").fadeIn("slow");
            //oculto aviso en 3 seg
            setTimeout(function() {
                $("#aviso").fadeOut("slow");
            }, 3000);
        });
    </script>
    {{-- <small>{{$prueba}}</small> --}}
    
</div>
