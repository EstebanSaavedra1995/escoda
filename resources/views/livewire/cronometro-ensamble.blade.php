
@if ($maquina == null || $maquina->CodMaquina == '0')
    <h2>No hay maquina Asignada </h2>
@else
    @if ($ordenE == null)
        <h2>
            No hay tarea asignada a esta Maquina
        </h2>
    @else
        <div class="" align=" center">
            @if ($estado == 'pausa')
                <div class="alert alert-danger" id="avisoPausa">Pausa Iniciada</div>
            @endif
            {{-- <small>{{$msj}}</small> --}}

            <div class="card border-dark" style="max-width: 95%;" align="left">
                <div class="card-header bg-primary">
                    <div class="row">
                        <h3 class="col">Maquina : {{ $maquina->CodMaquina }}
                            {{ $maquina->NombreMaquina }}
                        </h3>
                        <h3 class="col">Orden e. : {{ $ordenE->NroOE }} </h3>
                        <h3 class="col">Usuario : {{ auth()->user()->name }} </h3>
                    </div>


                    <input type="text" id="idTiempo" wire:model="idTiempo" hidden>


                </div>

                <div class="card-body container" style="max-width: 95%;">
                    <div class="row mb-2">
                        <h3 class="col col-4">Cantidad: {{ $detalleOE->Cantidad }}</h3>
                    </div>
                    <div class="row mb-2">
                        <h3 class="col" style="color:blue;">Total Piezas = {{ $cantidad }}</h3>
                    </div>
                    <div class="row mb-2" align="center">
                        <h1 id="screen" class="col mr-2">00:00:00</h1>
                    </div>

                    <div class="row mb-2">
                        <button onclick="start()" class=" btn btn-primary  col" id="start">Comenzar</button>&nbsp;
                        <button onclick="motivoPausa()" class=" btn btn-primary  col"
                            id="stop">Pausa</button>&nbsp;

                        <button onclick="finPausa()" class=" btn btn-primary  col"
                            id="resume">Continuar</button>&nbsp;
                        <button onclick="reset()" class=" btn btn-primary  col " id="reset">Terminar</button>

                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
