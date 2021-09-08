<div class="" align=" center">
    {{-- {{json_encode($maquinas)}} --}}
    {{-- @foreach ($maquinas as $item)
        {{$item['maquina']}}
    @endforeach --}}
    @foreach ($maquinas as $item)

        <div class="card border-primary mb-3 mt-2 ml-2" style="max-width: 100%;" align="left">
            <div class="card-header text-black bg-primary">
                <div class="row">
                    <h2 class="card-title col">Maquina: {{ $item['maquina']->CodMaquina }} </h2>
                    <h2 class="card-title col">Operario: {{ $item['detalleOC']->Operario }} </h2>
                </div>
                <div class="row">
                    <h3 class="col">Piezas Exitosas = {{ $item['exitosas'] }}</h3>
                    <h3 class="col">Piezas Fallidas = {{ $item['fallidas'] }}</h3>
                    <h3 class="col">Total Piezas = {{ $item['total'] }}</h3>
                    <button class="btn btn-light col-2" onclick="$('#{{$item['maquina']->CodMaquina}}').toggle();">Detalle</button>
                </div>
            </div>
            <div class="card-body container" id="{{$item['maquina']->CodMaquina}}" style="display:none">

                <table class="table table-striped border-dark">

                    <tr class="bg-dark text-light">

                        <head>

                            <th>Pieza</th>
                            <th>Tiempo</th>
                            <th>Estado</th>
                        </head>
                    </tr>
                    @foreach ($item['piezas'] as $pieza)
                        @if ($pieza->Estado == 'fallida')
                            <tr class="bg-danger text-light">

                            @else
                            <tr class="bg-primary text-light">
                        @endif
                        <td>{{ $pieza->Numero }}</td>
                        <td>{{ $pieza->Tiempo }}</td>
                        <td>{{ $pieza->Estado }}</td>
                        </tr>

                    @endforeach

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
            //alert(JSON.stringify(data));
            window.livewire.emit('recibido', data.datos);
        });
    </script>
</div>
