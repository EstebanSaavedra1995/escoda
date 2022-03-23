<?php

namespace App\Http\Livewire;

use App\Models\Cargos;
use App\Models\Personal;
use Livewire\Component;

class PersonalCreate extends Component
{

    public $nombre;
    public $cargo;
    public $fecha;
    public $estado;
    //public $cargos;

    public function mount()
    {
        $hoy = date("Y-m-d");
        $this->nombre = '';
        $this->cargo = '';
        $this->fecha = $hoy;
        $this->estado = '';
    }

    public function render()
    {
        $cargos = Cargos::all();
        return view('livewire.personal-create',compact('cargos'));
    }

    public function save()
    {
        $this->nombre->validate('require');
        $empleado= new Personal();
        $empleado->ApellidoNombre= $this->nombre;
        $empleado->Cargo= $this->cargo;
        $empleado->FechaIngreso= $this->fecha;
        $empleado->Estado= $this->estado;
        $empleado->save();
        $this->emit("save");
    }
}
