<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Events\Enviar;
use App\Models\DetalleOC;
use App\Models\DetalleOE;
use App\Models\Maquina;
use App\Models\Material;
use App\Models\OrdenEnsamble;
use App\Models\OrdenesConstruccion;
use App\Models\PausasOC;
use App\Models\PausasOE;
use App\Models\TiemposOC;
use App\Models\TiemposOE;
use DateTime;
use Request;

class CronometroEnsamble extends Component
{
    public $maquina;
    public $ordenE;
    public $detalleOE;
    public $tiempoOE;
    public $idTiempo;
    public $pausa;
    public $estado;
    public $cantidad;

    protected $listeners = [
        'reset' => 'fin',
        'start' => 'inicio',
        'pausa' => 'pausa',
        'finPausa' => 'finPausa',
        'recarga'
    ];

    public function mount($id)
    {
        $idMaq = Request::cookie('maquina');

        $this->maquina = Maquina::where('CodMaquina', $idMaq)->first();
        $this->ordenE = OrdenEnsamble::where('NroOE',$id)->first();
        
        if ($this->ordenE != null) {
            $this->detalleOE = DetalleOE::where('NroOE',$this->ordenE->NroOE)->first();
            $this->cantidadPiezas();
        }
    }

    public function render()
    { 
        $idMaq = Request::cookie('maquina');
        $this->maquina = Maquina::where('CodMaquina', $idMaq)->first();
        return view('livewire.cronometro-ensamble');
    }

    public function inicio($tiempoStart)
    {
        $idMaq = Request::cookie('maquina');
        $this->maquina = Maquina::where('CodMaquina', $idMaq)->first();

        $numero = TiemposOE::where('NroOE', $this->ordenE->NroOE)
            ->orderBy('Numero', 'DESC')->first();

        $tiempo = new TiemposOE();
        //$tiempo->idDetalleOC = $this->detalleOC->id;
        $tiempo->NroOE = $this->ordenE->NroOE;
        $tiempo->Tiempo = $tiempoStart;
        $tiempo->Estado = 'inicio';
        $tiempo->CodMaquina = $this->maquina->CodMaquina;
        $tiempo->Fecha = date("y-m-d H:i:s");
        $tiempo->idUsuario = auth()->user()->id;

        if ($numero != null) {
            $tiempo->Numero = $numero->Numero + 1;
        } else {
            $tiempo->Numero = 1;
        }

        $tiempo->save();

        $this->tiempoOE = TiemposOE::where('NroOE', $this->ordenE->NroOE)
            ->where('Numero', $tiempo->Numero)->first();
        $this->idTiempo = $this->tiempoOE->id;
        $this->emit("idTiempo");
        $this->estado = 'inicio';

        event(new Enviar($this->estado));
    }

    public function fin($estado, $tiempoPieza)
    {
        if ($this->tiempoOE->id != '0') {
            $tiempo = TiemposOE::find($this->tiempoOE->id);
            if ($tiempo->Estado == 'pausa') {
                $this->finPausa();
            }
            $tiempo->Tiempo = $tiempoPieza;
            $tiempo->Estado = $estado;
            $tiempo->Fecha = date("y-m-d H:i:s");
            $tiempo->save();
        }
        
        $this->cantidadPiezas();
        
        event(new Enviar($this->maquina->CodMaquina));
        
        if ($this->cantidad >= $this->detalleOE->Cantidad) {
            //$this->msj='ok';
            $detalle = OrdenEnsamble::find($this->ordenE->id);
            $detalle->Estado = 'finalizado';
            $detalle->save();
            
            return redirect()->route('horarios.maquinas');

        }
    }

    public function pausa($tipo)
    {
        $pausa = new PausasOE();
        $pausa->Tipo = $tipo;
        $pausa->inicio = date("y-m-d H:i:s");
        $pausa->IdOE = $this->ordenE->id;
        $pausa->idUsuario = auth()->user()->id;
        $pausa->saveOrFail();
        $this->pausa = $pausa;
        $this->estado = 'pausa';

        if ($this->tiempoOE->id != '0') {
            $tiempo = TiemposOE::find($this->tiempoOE->id);
            $tiempo->Estado = 'pausa';
            $tiempo->save();
            event(new Enviar($this->estado));
        }
    }

    public function finPausa()
    {
        if ($this->estado == 'pausa') {
            $pausa = PausasOE::where('IdOE', $this->ordenE->id)
                ->orderBy('id', 'DESC')->first();
            $pausa->Fin = date("y-m-d H:i:s");
            $pausa->saveOrFail();
            $this->estado = 'inicio';

            if ($this->tiempoOE->id != '0') {
                $tiempo = TiemposOE::find($this->tiempoOE->id);
                $tiempo->Estado = 'inicio';
                $tiempo->save();
                event(new Enviar($this->estado));
            }
        }
    }

    public function cantidadPiezas()
    {
        $piezas = TiemposOE::where('NroOE', $this->ordenE->NroOE)->get();
        $this->cantidad = count($piezas);
    }

    public function recarga($id)
    {
        $this->tiempoOC = TiemposOC::find($id);
        if ($this->tiempoOC != null) {
            $this->idTiempo = $this->tiempoOC->id;
            $this->estado = $this->tiempoOC->Estado;
        }
    }
}
