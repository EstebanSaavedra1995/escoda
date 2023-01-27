<div class="" align=" center">
    {{-- {{json_encode($maquinas)}} --}}
    {{-- @foreach ($maquinas as $item)
        {{$item['maquina']}}
    @endforeach --}}
    <div style="max-width: 50%;" class="container">
        <input type="text" class="form-control" wire:model="buscar" placeholder="Buscar por Nro. de OR">
    </div>
    
    @if (count($maquinas) > 0)
    <h1>Construcción</h1>
    @endif
    @foreach ($maquinas as $item) 

        <div class="card border-primary mb-3 mt-2 ml-2" style="max-width: 100%;" align="left">
            <div class="card-header text-black bg-primary">
                <div class="row">
                    <h4 class="col-4">Maquina: {{ $item['maquina']->CodMaquina }} -
                        {{ $item['maquina']->NombreMaquina }}</h4>
                    <h4 class="col-4">Operario: {{ $item['detalleOC']->Operario }} </h4>
                    <h4 class="col"> Pieza: {{$item['pieza']->NombrePieza}} </h4>
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
                    <a href="{{ route('listaTareas', $item['detalleOC']->id) }}" class="btn btn-secondary mr-2"
                        target="blank">Detalle</a>
                    <a href="{{ route('listaPausas', $item['detalleOC']->id) }}" class="btn btn-secondary"
                        target="blank">Pausas</a>
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
                                    <td>{{ $pieza->Estado }}</td>
                                    <script>
                                        localStorage.removeItem("{{ $pieza->id }}");
                                    </script>
                            @break
                            @case('exitosa')
                                <tr class="bg-primary text-light">
                                    <td>{{ $pieza->Numero }}</td>
                                    <td>{{ $pieza->Tiempo }}</td>
                                    <td>{{ $pieza->Estado }}</td>
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
                                    <td>{{ $pieza->Estado }} - {{$item['pausa']->Tipo}}</td>
                            @break
                            @case('inicio')
                                <tr class="bg-light">
                                    <input type="text" id="{{ $pieza->id }}" value="{{ $pieza->id }}"
                                        class="inicio" hidden>
                                    <td>{{ $pieza->Numero }}</td>
                                    <td>
                                        <p id="pantalla{{ $pieza->id }}"></p>
                                    </td>
                                    <td>{{ $pieza->Estado }}</td>
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

                        
                        <td>{{ $fechaDesde = date_format(date_create($pieza->Fecha), 'd/m/y H:i') }}</td>
                        <td>{{$item['operario']->ApellidoNombre}}</td>
                        </tr>
                    @endif
                    {{-- @endforeach --}}

                </table>
            </div>
        </div>
    @endforeach

    @if (count($ensambles) > 0)
        
    <h1>Ensamble</h1>
    @endif
    @foreach ($ensambles as $item) 

        <div class="card border-primary mb-3 mt-2 ml-2" style="max-width: 100%;" align="left">
            <div class="card-header text-black bg-primary">
                <div class="row">
                    <h4 class="col-4">Maquina: {{ $item['maquina']->CodMaquina }} -
                        {{ $item['maquina']->NombreMaquina }}</h4>
                    @if($item['user'] != null)
                    <h4 class="col-4">Operario: {{ $item['user']->name }} </h4>
                    @else
                    <h4 class="col-4">Operario:  </h4>
                    @endif
                    <h4 class="col"> Conjunto: {{$item['conjunto']->NombrePieza}} </h4>
                </div>
                <div class="row">
                    <h4 class="col-4">Orden E.: {{ $item['orden']->NroOE }} </h4>
                    {{-- <a href="{{ route('listaTareas', $item['detalleOC']->id) }}" class="btn btn-secondary mr-2"
                        target="blank">Detalle</a>
                    <a href="{{ route('listaPausas', $item['detalleOC']->id) }}" class="btn btn-secondary"
                        target="blank">Pausas</a> --}}
                </div>
            </div>
            <div class="card-body container" id="{{ $item['orden']->id }}" {{-- style="display:none" --}}>
                

                <table class="table table-striped border-dark">

                    <tr class="bg-dark text-light">

                        <head>
                            <th>Tiempo</th>
                            <th>Estado</th>
                            <th>Fecha/Hora</th>
                        </head>
                    </tr>
                    <p hidden>{{ $pieza = $item['tiempo'] }}</p>
                    @if ($pieza != null)


                        @switch($pieza->Estado)
                            @case('fallida')
                                <tr class="bg-danger text-light">
                                    <td>{{ $pieza->Tiempo }}</td>
                                    <td>{{ $pieza->Estado }}</td>
                                    <script>
                                        localStorage.removeItem("oe{{ $pieza->id }}");
                                    </script>
                            @break
                            @case('exitosa')
                                <tr class="bg-primary text-light">
                                    <td>{{ $pieza->Tiempo }}</td>
                                    <td>{{ $pieza->Estado }}</td>
                                    <script>
                                        localStorage.removeItem("oe{{ $pieza->id }}");
                                    </script>
                            @break
                            @case('pausa')
                                <tr class="bg-success text-light">
                                    <td>
                                        <p id="pantallaoe{{ $pieza->id }}"></p>
                                    </td>
                                    <td>{{ $pieza->Estado }} - {{$item['pausa']->Tipo}}</td>
                            @break
                            @case('inicio')
                                <tr class="bg-light">
                                    <input type="text" id="{{ $pieza->id }}" value="{{ $pieza->id }}"
                                        class="inicio" hidden>
                                    <td>
                                        <p id="pantallaoe{{ $pieza->id }}"></p>
                                    </td>
                                    <td>{{ $pieza->Estado }}</td>
                                    <script>
                                        if (localStorage.getItem("oe{{ $pieza->id }}") == null) {
                                            localStorage.setItem("oe{{ $pieza->id }}", "{{ $pieza->Fecha }}");
                                            console.log(localStorage.getItem("oe{{ $pieza->id }}"));
                                        } else {
                                            console.log('esta seteado');
                                        }
                                        start();
                                    </script>
                            @break
                            @default

                        @endswitch

                        
                        <td>{{ $fechaDesde = date_format(date_create($pieza->Fecha), 'd/m/y H:i') }}</td>
                        </tr>
                    @endif

                </table>
            </div>
        </div>
    @endforeach

    @if (count($reparaciones) > 0)
        
    <h1>Reparación</h1>
    @endif
    @foreach ($reparaciones as $item) 

        <div class="card border-primary mb-3 mt-2 ml-2" style="max-width: 100%;" align="left">
            <div class="card-header text-black bg-primary">
                <div class="row">
                    <h4 class="col-4">Maquina: {{ $item['maquina']->CodMaquina }} -
                        {{ $item['maquina']->NombreMaquina }}</h4>
                    @if($item['user'] != null)
                    <h4 class="col-4">Operario: {{ $item['user']->name }} </h4>
                    @else
                    <h4 class="col-4">Operario:  </h4>
                    @endif
                    <h4 class="col"> Conjunto: {{$item['conjunto']->NombrePieza}} </h4>
                </div>
                <div class="row">
                    <h4 class="col-4">Orden E.: {{ $item['orden']->NroOR }} </h4>
                    {{-- <a href="{{ route('listaTareas', $item['detalleOC']->id) }}" class="btn btn-secondary mr-2"
                        target="blank">Detalle</a>
                    <a href="{{ route('listaPausas', $item['detalleOC']->id) }}" class="btn btn-secondary"
                        target="blank">Pausas</a> --}}
                </div>
            </div>
            <div class="card-body container" id="{{ $item['orden']->id }}" {{-- style="display:none" --}}>
                

                <table class="table table-striped border-dark">

                    <tr class="bg-dark text-light">

                        <head>
                            <th>Tiempo</th>
                            <th>Estado</th>
                            <th>Fecha/Hora</th>
                        </head>
                    </tr>
                    <p hidden>{{ $pieza = $item['tiempo'] }}</p>
                    @if ($pieza != null)


                        @switch($pieza->Estado)
                            @case('fallida')
                                <tr class="bg-danger text-light">
                                    <td>{{ $pieza->Tiempo }}</td>
                                    <td>{{ $pieza->Estado }}</td>
                                    <script>
                                        localStorage.removeItem("or{{ $pieza->id }}");
                                    </script>
                            @break
                            @case('exitosa')
                                <tr class="bg-primary text-light">
                                    <td>{{ $pieza->Tiempo }}</td>
                                    <td>{{ $pieza->Estado }}</td>
                                    <script>
                                        localStorage.removeItem("or{{ $pieza->id }}");
                                    </script>
                            @break
                            @case('pausa')
                                <tr class="bg-success text-light">
                                    <td>
                                        <p id="pantallaoe{{ $pieza->id }}"></p>
                                    </td>
                                    <td>{{ $pieza->Estado }} - {{$item['pausa']->Tipo}}</td>
                            @break
                            @case('inicio')
                                <tr class="bg-light">
                                    <input type="text" id="{{ $pieza->id }}" value="{{ $pieza->id }}"
                                        class="inicio" hidden>
                                    <td>
                                        <p id="pantallaor{{ $pieza->id }}"></p>
                                    </td>
                                    <td>{{ $pieza->Estado }}</td>
                                    <script>
                                        if (localStorage.getItem("or{{ $pieza->id }}") == null) {
                                            localStorage.setItem("or{{ $pieza->id }}", "{{ $pieza->Fecha }}");
                                            console.log(localStorage.getItem("or{{ $pieza->id }}"));
                                        } else {
                                            console.log('esta seteado');
                                        }
                                        start();
                                    </script>
                            @break
                            @default

                        @endswitch

                        
                        <td>{{ $fechaDesde = date_format(date_create($pieza->Fecha), 'd/m/y H:i') }}</td>
                        </tr>
                    @endif

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
