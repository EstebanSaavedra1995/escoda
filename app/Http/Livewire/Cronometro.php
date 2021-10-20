<?php

namespace App\Http\Livewire;

use App\Events\Enviar;
use App\Models\DetalleOC;
use App\Models\Maquina;
use App\Models\Material;
use App\Models\OrdenesConstruccion;
use App\Models\PausasOC;
use App\Models\TiemposOC;
use DateTime;
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
    public $material;
    public $tiempoOC;
    public $idTiempoOC;
    public $pausa;


    protected $listeners = [
        'reset' => 'fin',
        'start' => 'inicio',
        'guardarPausa' => 'guardarPausa',
        'actualizarPausa' => 'actualizarPausa'
    ];

    public function fin($estadoPieza)
    {
        $this->estado = $estadoPieza;
        $this->actualizarTiempoOC();
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
        $this->idTiempoOC = '0';
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

    public function pausa()
    {
        $this->estado = 'pausa';
        //$this->guardarTiempoOC();
        $this->actualizarTiempoOC();
        $this->emit("pausa");
        event(new Enviar('pausa'));
    }
    public function inicio()
    {
        $this->estado = 'inicio';
        $this->guardarTiempoOC();
        event(new Enviar('inicio'));
    }

    public function continuar()
    {
        $this->estado = 'inicio';
        $this->actualizarTiempoOC();
        $this->emit("continuar");
        event(new Enviar('inicio'));
    }

    public function guardarPausa($tipo){
        $pausa = new PausasOC();
        $pausa->Tipo = $tipo;
        $pausa->inicio = date("y-m-d H:i:s");
        $pausa->IdDetalleOC = $this->detalleOC->id;
        $pausa->saveOrFail();
        $this->pausa = $pausa;
    }

    public function actualizarPausa(){
        $pausa = PausasOC::where('IdDetalleOC',$this->detalleOC->id)
                        ->orderBy('id', 'DESC')->first();;
        $pausa->Fin = date("y-m-d H:i:s");
        $pausa->saveOrFail();
    }

    public function guardarTiempoOC()
    {
        $id = Request::cookie('maquina');
        $this->maquina = Maquina::where('CodMaquina', $id)->first();
        $this->detalleOC = DetalleOC::where('Maquina', 'like', '%' . $this->maquina->CodMaquina . '%')
            ->where('Estado', 'pendiente')
            ->orderBy('Tarea', 'ASC')->first();
        $this->ordenC = OrdenesConstruccion::where('NroOC', $this->detalleOC->NroOC)->first();

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
        } else {
            $tiempo->Numero = 1;
        }
        $tiempo->save();
        $this->tiempoOC = TiemposOC::where('idDetalleOC', $this->detalleOC->id)
            ->where('Numero', $tiempo->Numero)->first();
        $this->idTiempoOC = $this->tiempoOC->id;
        $this->emit("guardado",$this->idTiempoOC);
    }

    public function actualizarTiempoOC()
    {
        if ($this->idTiempoOC != '0') {
            $tiempo = TiemposOC::find($this->idTiempoOC);
            $tiempo->Tiempo = $this->tiempo;
            $tiempo->Estado = $this->estado;
            $tiempo->Fecha = date("y-m-d H:i:s");
            $tiempo->save();
        }
    }

    public function cargarDatos()
    {
        $id = Request::cookie('maquina');
        $this->maquina = Maquina::where('CodMaquina', $id)->first();
        $this->detalleOC = DetalleOC::where('Maquina', 'like', '%' . $this->maquina->CodMaquina . '%')
            ->where('Estado', 'pendiente')
            ->orderBy('Tarea', 'ASC')->first();
        $this->ordenC = OrdenesConstruccion::where('NroOC', $this->detalleOC->NroOC)->first();

        $this->material = Material::where('CodigoMaterial', $this->ordenC->CodigoMaterial)->first();

        $fallas = TiemposOC::where('idDetalleOC', $this->detalleOC->id)
            ->where('Estado', 'fallida')->get();
        $exitos = TiemposOC::where('idDetalleOC', $this->detalleOC->id)
            ->where('Estado', 'exitosa')->get();

        $this->fallidas = count($fallas);
        $this->exitosas = count($exitos);

        $this->cantidad = $this->fallidas + $this->exitosas;
        if ($this->idTiempoOC != '0') {
            $tiempo = TiemposOC::find($this->idTiempoOC);
        }
        $this->emit("refresh");
    }
}
