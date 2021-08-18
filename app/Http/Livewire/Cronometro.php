<?php

namespace App\Http\Livewire;

use App\Events\Enviar;
use Livewire\Component;

class Cronometro extends Component
{
    public $cantidad;
    public $pieza;
    public $estado;
    public $tiempo;
    public $exitosas;
    public $fallidas;
    public $enviado;

    public function mount()
    {
        $this->cantidad = "0";
        $this->pieza = [];
        $this->tiempo = '';
        $this->estado = '';
        $this->exitosas = '0';
        $this->fallidas = '0';
    }


    public function render()
    {
        return view('livewire.cronometro');
    }

    public function enviarDatos()
    {
        $this->pieza = [
            'estado' => $this->estado,
            'tiempo' => $this->tiempo,
            'numero' => $this->cantidad
        ];
        //$this->emit("recibido",$this->cantidad);
        $this->emit("enviado");
        event(new Enviar($this->cantidad, $this->pieza));
    }
}
