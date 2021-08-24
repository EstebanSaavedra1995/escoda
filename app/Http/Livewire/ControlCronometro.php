<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ControlCronometro extends Component
{
    public $datos;
    public $cantidad;
    public $piezas;
    public $exitosas;
    public $fallidas;
    protected $listeners = ["recibido"];

    public function mount(){
        $this->datos = '';
        $this->piezas = [];
        $this->cantidad = '0';
        $this->exitosas = 0;
        $this->fallidas = 0;
    }

    public function recibido($datos)
    {
        $this->cantidad = $datos['cantidad'];
        $this->piezas[] = $datos['pieza'];
        if ($datos['pieza']['estado'] == 'fallida') {
            $this->fallidas++;
        } else {
            $this->exitosas++;
        }
        
    }

    public function render()
    {
        return view('livewire.control-cronometro');
    }
}
