<div>
    <h5>lista</h5>
    <ul>
        @foreach ($lista as $item)

            <li>{{ $item }}</li>
        @endforeach
    </ul>


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
            window.livewire.emit('recibido', data.prueba);
        });
    </script>
</div>
