<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ArticulosCreate extends Component
{
    public $tipo;

    
    public function render()
    {
        return view('livewire.articulos-create');
    }
}
