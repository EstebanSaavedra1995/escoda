<?php

namespace App\Http\Livewire;

use App\Models\Pieza;
use Livewire\Component;

class OrdenConstruccion extends Component
{
    public $piezas;

    public function render()
    {   
        $this->piezas = Pieza::all();
        return view('livewire.orden-construccion');
    }
}
