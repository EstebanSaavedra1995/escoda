<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
//implements ShouldBroadcast implementar manualmente
class Enviar implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $datos;

    public function __construct($codMaquina)
    {
        $this->datos = $codMaquina;
    }

    public function broadcastOn()
    {
        return 'escoda-channel';
    }

    public function broadcastAs()
    {
        return "escoda-event";
    }
}
