<?php

namespace App\Http\Livewire;

use Livewire\Component;

class HorariosLista extends Component
{   //funciones arriba de render sino no cargan
    public $lista;

    protected $listeners = ["recibido"];

    public function mount()
    {
        $this->lista = [];
    }
    
    public function recibido($prueba)
    {
        $this->lista[] = $prueba;
    }
    public function render()
    {
        return view('livewire.horarios-lista');
    }

}
