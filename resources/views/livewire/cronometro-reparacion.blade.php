@if ($maquina == null || $maquina->CodMaquina == '0')
    <h2>No hay maquina Asignada </h2>
@else
    @if ($ordenR == null)
        <h2>
            No hay tarea asignada a esta Maquina
        </h2>
    @else
        <div>

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
                            <h3 class="col">Orden R. : {{ $ordenR->NroOR }} </h3>
                            <h3 class="col">Usuario : {{ auth()->user()->name }} </h3>
                        </div>


                        <input type="text" id="idTiempo" wire:model="idTiempo" hidden>


                    </div>

                    <div class="card-body container" style="max-width: 95%;">
                        {{-- <div class="row mb-2">
                    <h3 class="col col-4">Cantidad:</h3>
                </div>
                <div class="row mb-2">
                    <h3 class="col" style="color:blue;">Total Piezas =</h3>
                </div> --}}
                        <div class="row mb-2" align="center">
                            <h1 id="screen" class="col mr-2">00:00:00</h1>
                        </div>

                        <div class="row mb-2">
                            <button onclick="start()" class=" btn btn-primary  col"
                                id="start">Comenzar</button>&nbsp;
                            <button onclick="motivoPausa()" class=" btn btn-primary  col"
                                id="stop">Pausa</button>&nbsp;

                            <button onclick="finPausa()" class=" btn btn-primary  col"
                                id="resume">Continuar</button>&nbsp;
                            <button onclick="reset()" class=" btn btn-primary  col " id="reset">Terminar</button>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                {{-- {{json_encode($cambiosArticulos)}} --}}
                @if (count($articulos) > 0)
                    <h3 class="m-4">Artículos</h3>
                    <div class="row">

                        <table class="table table-bordered table-striped col-6 m-4" style="text-align: center;">
                            <thead>
                                <tr>

                                    <th>Artículo</th>
                                    <th>Cambiado</th>
                                    {{-- <th>Cantidad</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($articulos as $item)
                                    @if ($item != null)
                                        <tr>
                                            <td>{{ $item['articulo']['Descripcion'] }}</td>
                                            <td><input type="checkbox" wire:model="cambiosArticulos"
                                                    value="{{ $item['articulo']['CodArticulo'] }}" class="form-control"></td>
                                            {{-- <td><input type="number" 
                                                    value="{{ $item['cantidad'] }}" max="{{ $item['cantidad'] }}" min="0" class="form-control"></td> --}}
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                {{-- {{json_encode($cambiosGomas)}} --}}
                @if (count($gomas) > 0)
                    <h3 class="m-4">Gomas</h3>
                    <div class="row">

                        <table class="table table-bordered table-striped col-6 m-4" style="text-align: center;">
                            <thead>
                                <tr>

                                    <th>Goma</th>
                                    <th>Cambiado</th>
                                    {{-- <th>Cantidad</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gomas as $item)
                                    @if ($item != null)
                                        <tr>
                                            <td>{{ $item['goma']['CodigoGoma'] }}</td>
                                            <td><input type="checkbox" wire:model="cambiosGomas"
                                                    value="{{ $item['goma']['CodigoGoma'] }}" class="form-control"></td>
                                            {{-- <td><input type="number" 
                                                        value="{{ $item['cantidad'] }}" max="{{ $item['cantidad'] }}" min="0" class="form-control"></td> --}}
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if (count($piezas) > 0)
                    <h3 class="m-4">Piezas</h3>
                    <div class="row">

                        <table class="table table-bordered table-striped col-6 m-4" style="text-align: center;">
                            <thead>
                                <tr>

                                    <th>Pieza</th>
                                    <th>Cambiado</th>
                                    {{-- <th>Cantidad</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($piezas as $item)
                                    @if ($item != null)
                                        <tr>
                                            <td>{{ $item['pieza']['NombrePieza'] }}</td>
                                            <td><input type="checkbox" wire:model="cambiosPiezas"
                                                    value="{{ $item['pieza']['CodPieza'] }}" class="form-control"></td>
                                            {{-- <td><input type="number" 
                                                        value="{{ $item['cantidad'] }}" max="{{ $item['cantidad'] }}" min="0" class="form-control"></td> --}}
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif
            </div>
        </div>
    @endif
@endif
