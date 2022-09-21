{{-- <small>{{substr($detalleOC->Operario, 0, 3)}} -ses {{ auth()->user()->NroLegajo }} </small> --}}
@if ($maquina == null || $maquina->CodMaquina == '0')
    <h2>No hay maquina Asignada </h2>
@else
    @if ($detalleOC == null)
        <h2>
            No hay tarea asignada a esta Maquina
        </h2>
    @else
        {{-- @if (substr($detalleOC->Operario, 0, 3) == auth()->user()->NroLegajo) --}}
        <div class="" align=" center">
            @if ($estado == 'pausa')
                <div class="alert alert-danger" id="avisoPausa">Pausa Iniciada</div>
            @endif
            {{-- <small>{{$estado}}</small> --}}

            <div class="card border-dark" style="max-width: 95%;" align="left">
                <div class="card-header bg-primary">
                    <div class="row">
                        <h3 class="col">Maquina : {{ $maquina->CodMaquina }}
                            {{ $maquina->NombreMaquina }}
                        </h3>
                        <h3 class="col">Orden c. : {{ $ordenC->NroOC }} </h3>
                        <h3 class="col">Usuario : {{ auth()->user()->name }} </h3>
                    </div>

                    {{-- <input type="text" id="cantidad" wire:model="cantidad" hidden>
                        <input type="text" id="tiempo" wire:model="tiempo" hidden>
                        <input type="text" id="estado" wire:model="estado" hidden>
                        <input type="text" id="exitosas" wire:model="exitosas" hidden>
                        <input type="text" id="fallidas" wire:model="fallidas" hidden>
                        <input type="text" id="flagPausa" value="f" hidden> --}}
                    <input type="text" id="idTiempo" wire:model="idTiempo" hidden>


                </div>

                <div class="card-body container" style="max-width: 95%;">
                    <div class="row mb-2">
                        <h3 class="col col-4">Cantidad: {{ $ordenC->Cantidad }}</h3>
                        <h3 class="col col-4">Long. de Corte: {{ $ordenC->LongitudCorte }}</h3>
                        <h3 class="col col-4">Renglon: {{ $detalleOC->Renglon }}</h3>
                        <h3 class="col col-4">Material: {{ $material->Material }}</h3>
                        <h3 class="col col-4">Calidad: {{ $material->Calidad }}</h3>
                        <h3 class="col col-4">Colada: {{ $ordenC->Colada }}</h3>
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
                        <button onclick="motivoPausa()" class=" btn btn-primary  col"
                            id="stop">Pausa</button>&nbsp;
                        {{-- <button wire:click="pausa" class=" btn btn-primary  col" id="stop">Pausa</button>&nbsp; --}}
                        {{-- <button wire:click="continuar" class=" btn btn-primary  col"
                                id="resume">Continuar</button>&nbsp; --}}
                        <button onclick="finPausa()" class=" btn btn-primary  col"
                            id="resume">Continuar</button>&nbsp;
                        <button onclick="reset()" class=" btn btn-primary  col " id="reset">Terminar</button>

                    </div>
                    {{-- <div class="mt-5" align="center">
                            <button class="btn btn-success col-3" wire:click="enviarDatos" id="enviar">Enviar</button>
                        </div> --}}

                </div>
                {{-- alert de recibido --}}
                {{-- <div style="position:absolute; top:50%; right: 50%;" class="alert alert-success collapse" role="alert"
            id="aviso">
            Enviado</div> --}}
            </div>
        </div>
        {{-- @else
                <div align="center">
                    <h2>Usuario incorrecto, esperando a {{ substr($detalleOC->Operario, 6) }}</h2>
                    <h2>Tarea: {{$detalleOC->Tarea}}  </h2>
                    <h2>Nro. Orden: {{$detalleOC->NroOC}}</h2>
                </div>
        @endif --}}
    @endif
@endif
{{-- <script>
    controlBotones();
</script> --}}

{{-- script que recibe evento --}}
{{-- <script>
    window.livewire.on('idTiempo', function() {
        //swal("Pausa iniciada", "", );
        console.log('id: ' + document.getElementById('idTiempo').value);
    });
</script> --}}
