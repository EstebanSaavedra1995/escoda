<?php
//crear cuenta en pusher e instalar paquete video5
//configurar .env
//driver de brodacast a pusher
namespace App\Http\Livewire;

use App\Events\Enviar;
use Livewire\Component;

class ControlHorarios extends Component
{
    public $prueba;

    public function mount(){
        $this->prueba = "";
    }
    public function render()
    {
        return view('livewire.control-horarios');
    }
    public function enviar(){
        //en caso de mandar mas de una variable
        /* $datos = [
            "dato1" => $this->dato1,
            "dato2" => $this->dato2
        ];
        $this->emit("recibido",$datos); */
        $this->validate([
            "prueba"=>"required"
        ]);
        $this->emit("enviado");
        //$this->emit("recibido",$this->prueba);
        event(new Enviar($this->prueba));
    }
}
