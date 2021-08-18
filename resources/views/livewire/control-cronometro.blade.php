<div class="" align="center">
    <div class="card border-primary mb-3 mt-2 ml-2" style="max-width: 80%;" align="left">
        <div class="card-header text-black bg-primary">
            <div class="row">
                <h2 class="card-title col">Maquina: </h2>
                <h2 class="card-title col">Usuario: </h2>
            </div>
            <div class="row">
                <h3 class="">Piezas Exitosas = {{$exitosas}}</h3>
                <h3 class="">Piezas Fallidas = {{$fallidas}}</h3>
                <h3 class="col">Total Piezas = {{ $cantidad }}</h3>
                <button class="btn btn-light col-2">Detalle</button>
            </div>
        </div>
        <div class="card-body container" id="detalles">

            <table class="table table-striped border-dark">

                <tr class="bg-dark text-light">

                    <head>

                        <th>Pieza</th>
                        <th>Tiempo</th>
                        <th>Estado</th>
                    </head>
                </tr>
                @foreach ($piezas as $item)
                    @if ($item['estado'] == 'fallida')
                        <tr class="bg-danger text-light">

                        @else
                        <tr class="bg-primary text-light">
                    @endif
                    <td>{{ $item['numero'] }}</td>
                    <td>{{ $item['tiempo'] }}</td>
                    <td>{{ $item['estado'] }}</td>
                    </tr>

                @endforeach

            </table>
        </div>
    </div>

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
