<div class="" align=" center">
    {{-- {{json_encode($maquinas)}} --}}
    {{-- @foreach ($maquinas as $item)
        {{$item['maquina']}}
    @endforeach --}}
    <div style="max-width: 50%;" class="container">
        <input type="text" class="form-control" wire:model="buscar" placeholder="Buscar por Nro. de OR">
    </div>
    

    @foreach ($maquinas as $item)

        <div class="card border-primary mb-3 mt-2 ml-2" style="max-width: 100%;" align="left">
            <div class="card-header text-black bg-primary">
                <div class="row">
                    <h4 class="col-4">Maquina: {{ $item['maquina']->CodMaquina }} -
                        {{ $item['maquina']->NombreMaquina }}</h4>
                    <h4 class="col-4">Operario: {{ $item['detalleOC']->Operario }} </h4>
                    <h4 class="col"></h4>
                </div>
                <div class="row">
                    <h4 class="col-4">Tarea: {{ $item['detalleOC']->Tarea }} </h4>
                    <h4 class="col-4">Orden C.: {{ $item['detalleOC']->NroOC }} </h4>
                    {{-- <h4 class="col">Cantidad = {{ $item['ordenC']->Cantidad }}</h4>
                    <h4 class="col">Piezas Exitosas = {{ $item['exitosas'] }}</h4>
                    <h4 class="col">Piezas Fallidas = {{ $item['fallidas'] }}</h4>
                    <h4 class="col">Total Piezas = {{ $item['total'] }}</h4> --}}
                    {{-- <button class="btn btn-light col-2"
                        onclick="$('#{{ $item['detalleOC']->id }}').toggle();">Detalle</button> --}}
                    {{-- <button class="btn btn-light col-2"
                        onclick="">Detalle</button> --}}
                    <a href="{{ route('listaTareas', $item['detalleOC']->id) }}" class="btn btn-secondary"
                        target="blank">Detalle</a>
                </div>
            </div>
            <div class="card-body container" id="{{ $item['detalleOC']->id }}" {{-- style="display:none" --}}>
                <div class="row">

                    <h4 class="col">Piezas Exitosas = {{ $item['exitosas'] }}</h4>
                    <h4 class="col">Cantidad a realizar = {{ $item['ordenC']->Cantidad }}</h4>
                </div>

                <div class="row">
                    <h4 class="col">Piezas Fallidas = {{ $item['fallidas'] }}</h4>
                </div>

                <div class="row">
                    <h4 class="col">Total Piezas = {{ $item['total'] }}</h4>
                </div>

                <table class="table table-striped border-dark">

                    <tr class="bg-dark text-light">

                        <head>

                            <th>Pieza</th>
                            <th>Tiempo</th>
                            <th>Estado</th>
                            <th>Fecha/Hora</th>
                            <th>Operario</th>
                        </head>
                    </tr>
                    {{-- @foreach ($item['piezas'] as $pieza) --}}
                    <p hidden>{{ $pieza = $item['piezas'] }}</p>
                    @if ($pieza != null)


                        @switch($pieza->Estado)
                            @case('fallida')
                                <tr class="bg-danger text-light">
                                    <td>{{ $pieza->Numero }}</td>
                                    <td>{{ $pieza->Tiempo }}</td>
                                    <script>
                                        localStorage.removeItem("{{ $pieza->id }}");
                                    </script>
                            @break
                            @case('exitosa')
                                <tr class="bg-primary text-light">
                                    <td>{{ $pieza->Numero }}</td>
                                    <td>{{ $pieza->Tiempo }}</td>
                                    <script>
                                        localStorage.removeItem("{{ $pieza->id }}");
                                    </script>
                            @break
                            @case('pausa')
                                <tr class="bg-success text-light">
                                    <td>{{ $pieza->Numero }}</td>
                                    <td>
                                        <p id="pantalla{{ $pieza->id }}"></p>
                                    </td>
                            @break
                            @case('inicio')
                                <tr class="bg-light">
                                    <input type="text" id="{{ $pieza->id }}" value="{{ $pieza->id }}"
                                        class="inicio" hidden>
                                    <td>{{ $pieza->Numero }}</td>
                                    <td>
                                        <p id="pantalla{{ $pieza->id }}"></p>
                                    </td>
                                    <script>
                                        if (localStorage.getItem("{{ $pieza->id }}") == null) {
                                            localStorage.setItem("{{ $pieza->id }}", "{{ $pieza->Fecha }}");
                                            console.log(localStorage.getItem("{{ $pieza->id }}"));
                                        } else {
                                            console.log('esta seteado');
                                            //localStorage.removeItem("{{ $pieza->id }}");
                                        }
                                        //document.location.reload();
                                        start();
                                    </script>
                            @break
                            @default

                        @endswitch

                        <td>{{ $pieza->Estado }}</td>
                        <td>{{ $fechaDesde = date_format(date_create($pieza->Fecha), 'd/m/y H:i') }}</td>
                        <td>{{$item['operario']->ApellidoNombre}}</td>
                        </tr>
                    @endif
                    {{-- @endforeach --}}

                </table>
            </div>
        </div>
    @endforeach

    {{-- script de pusher --}}
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('16ad6874e515628ca0c4', {
            cluster: 'us2'
        });

        var channel = pusher.subscribe('escoda-channel');
        channel.bind('escoda-event', function(data) {
            //alert(JSON.stringify(data.datos));
            if (data.datos == 'inicio') {
            }
            //start();
            window.livewire.emit('recibido', data.datos);
        });
    </script>

    <script>
        window.livewire.on('inicios', function(data) {
            console.log('dsadasdasasdsd');
            //localStorage.setItem("idTiempo", document.getElementById('idTiempo').value);
            console.log('data: '+data);
        });
    </script>

<script src="{{ asset('js/controlCronometro.js') }}"></script>
</div>
