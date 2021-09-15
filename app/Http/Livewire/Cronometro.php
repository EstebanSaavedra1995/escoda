<?php

namespace App\Http\Livewire;

use App\Events\Enviar;
use App\Models\DetalleOC;
use App\Models\Maquina;
use App\Models\OrdenesConstruccion;
use App\Models\TiemposOC;
use Request;
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
    public $maquina;
    public $detalleOC;
    public $ordenC;


    protected $listeners = ['reset' => 'contar'];

    public function contar($estadoPieza)
    {
        $this->estado = $estadoPieza;
        $this->guardarTiempoOC();
        $this->cargarDatos();
    }

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
        //$this->guardarTiempoOC();
        $this->cargarDatos();
        
        return view('livewire.cronometro');
    }

    public function enviarDatos()
    {
        //$this->guardarTiempoOC(); 
/*         $this->pieza = [
            'estado' => $this->estado,
            'tiempo' => $this->tiempo,
            'numero' => $this->cantidad
        ]; */

        //$this->emit("recibido",$this->cantidad);
        $this->emit("enviado");
        event(new Enviar($this->maquina->CodMaquina));

    }

    public function guardarTiempoOC(){
        $id = Request::cookie('maquina');
        $this->maquina = Maquina::where('CodMaquina',$id)->first();
        $this->detalleOC = DetalleOC::where('Maquina','like','%'. $this->maquina->CodMaquina .'%')
                                        ->where('Estado','pendiente')
                                        ->orderBy('Tarea','ASC')->first();
        $this->ordenC = OrdenesConstruccion::where('NroOC',$this->detalleOC->NroOC)->first();

        $numero = TiemposOC::where('idDetalleOC', $this->detalleOC->id)->get();
        //->where('CodMaquina', $this->maquina->CodMaquina)
        $tiempo = new TiemposOC();
        $tiempo->idDetalleOC = $this->detalleOC->id;
        $tiempo->NroOC = $this->ordenC->NroOC;
        $tiempo->Tiempo = $this->tiempo;
        $tiempo->Estado = $this->estado;
        $tiempo->CodMaquina = $this->maquina->CodMaquina;
        $tiempo->Fecha = date("y-m-d H:i:s");
        if (count($numero)) {
            $tiempo->Numero = count($numero) + 1;
        }else{
            $tiempo->Numero = 1;
        }
        $tiempo->save();
    }

    public function cargarDatos(){
        $id = Request::cookie('maquina');
        $this->maquina = Maquina::where('CodMaquina',$id)->first();
        $this->detalleOC = DetalleOC::where('Maquina','like','%'. $this->maquina->CodMaquina .'%')
                                        ->where('Estado','pendiente')
                                        ->orderBy('Tarea','ASC')->first();
        $this->ordenC = OrdenesConstruccion::where('NroOC',$this->detalleOC->NroOC)->first();

        $fallas = TiemposOC::where('idDetalleOC', $this->detalleOC->id)
                            ->where('Estado','fallida')->get();
        $exitos = TiemposOC::where('idDetalleOC', $this->detalleOC->id)
                            ->where('Estado','exitosa')->get();

        $this->fallidas = count($fallas);
        $this->exitosas = count($exitos);

        $this->cantidad = $this->fallidas + $this->exitosas;
    }


}
