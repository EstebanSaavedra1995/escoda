<?php

namespace App\Http\Livewire;

use App\Models\Pieza;
use Livewire\Component;

class ControlStockEgreso extends Component
{
    public function render()
    {
        return view('livewire.control-stock-egreso');
    }

    public function egreso($id,$tipo){
        $pieza = Pieza::find($id);
        return view('admin/stock/controlStockEgreso',compact('pieza','tipo'));
    }
}
