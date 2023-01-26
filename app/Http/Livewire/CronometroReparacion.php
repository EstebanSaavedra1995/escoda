<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Events\Enviar;
use App\Models\ArticulosGenerales;
use App\Models\Conjunto;
use App\Models\ConjuntoArticulos;
use App\Models\ConjuntoGomas;
use App\Models\DetalleOC;
use App\Models\DetalleOE;
use App\Models\DetalleReparacionArticulo;
use App\Models\DetalleReparacionGoma;
use App\Models\DetalleReparacionPieza;
use App\Models\Goma;
use App\Models\Maquina;
use App\Models\Material;
use App\Models\OrdenEnsamble;
use App\Models\OrdenesConstruccion;
use App\Models\OrdenReparacion;
use App\Models\PausasOC;
use App\Models\PausasOE;
use App\Models\PausasOR;
use App\Models\Pieza;
use App\Models\PiezaDeConjunto;
use App\Models\TiemposOC;
use App\Models\TiemposOE;
use App\Models\TiemposOR;
use DateTime;
use Request;

class CronometroReparacion extends Component
{

    public $maquina;
    public $ordenR;
    public $detalleArticulos;
    public $detalleGomas;
    public $detallePiezas;
    public $tiempoOR;
    public $idTiempo;
    public $pausa;
    public $estado;
    public $cantidad;
    public $conjunto;

    public $prueba;
    public $piezas=[];
    public $articulos=[];
    public $gomas=[];
    public $cambiosArticulos = [];
    public $cambiosGomas =[];
    public $cambiosPiezas =[];
    public $cantidadArticulos = [];
    public $cantidadGomas =[];
    public $cantidadPiezas =[];
    protected $listeners = [
        'reset' => 'fin',
        'start' => 'inicio',
        'pausa' => 'pausa',
        'finPausa' => 'finPausa',
        'recarga',
        'clickArticulo'
    ];

    public function mount($id)
    {
        $idMaq = Request::cookie('maquina');
        $this->prueba ="hoal";
        $this->maquina = Maquina::where('CodMaquina', $idMaq)->first();
        $this->ordenR = OrdenReparacion::where('NroOR',$id)->first();
        $this->conjunto = Conjunto::where('CodPieza',$this->ordenR->CodConjunto)->first();
        
        $this->detalleArticulos = ConjuntoArticulos::where('CodPieza',$this->ordenR->CodConjunto)->get();
        foreach ($this->detalleArticulos as $detalle) {
            $this->articulos[]= [
                'articulo' => ArticulosGenerales::where('CodArticulo',$detalle->CodArticulo)->first(),
                'cantidad' => $detalle->Cantidad  
            ];
            $this->cantidadArticulos[]=[
                $detalle->CodArticulo => $detalle->Cantidad  
            ]; 
        }
        
        $this->detalleGomas = ConjuntoGomas::where('CodPieza',$this->ordenR->CodConjunto)->get();
        foreach ($this->detalleGomas as $detalle) {
            $this->gomas[] = [
                'goma' => Goma::where('CodigoGoma',$detalle->CodigoGoma)->first(),
                'cantidad' => $detalle->Cantidad
            ]; 
        }
        
        $this->detallePiezas = PiezaDeConjunto::where('codigoCjto',$this->ordenR->CodConjunto)->get();
         foreach ($this->detallePiezas as $detalle) {
            $this->piezas[] = [
                'pieza' => Pieza::where('CodPieza',$detalle->codigoPieza)->first(),
                'cantidad' => $detalle->Cantidad
            ];
         }
        //echo $this->piezas[0];
        
    }

    public function render()
    {
        return view('livewire.cronometro-reparacion');
    }


    public function clickArticulo($cod){
      
        
        
    }

    public function inicio($tiempoStart) 
    {
        $idMaq = Request::cookie('maquina');
        $this->maquina = Maquina::where('CodMaquina', $idMaq)->first();

        /*$numero = TiemposOR::where('NroOR', $this->ordenR->NroOR)
            ->orderBy('Numero', 'DESC')->first();*/

        $tiempo = new TiemposOR();
        //$tiempo->idDetalleOC = $this->detalleOC->id;
        $tiempo->NroOR = $this->ordenR->NroOR;
        $tiempo->Tiempo = $tiempoStart;
        $tiempo->Estado = 'inicio';
        $tiempo->CodMaquina = $this->maquina->CodMaquina;
        $tiempo->Fecha = date("y-m-d H:i:s");
        $tiempo->idUsuario = auth()->user()->id;

        /*if ($numero != null) {
            $tiempo->Numero = $numero->Numero + 1;
        } else {
            $tiempo->Numero = 1;
        }*/

        $tiempo->save();

        $this->tiempoOR = TiemposOR::where('NroOR', $this->ordenR->NroOR)->first();
           // ->where('Numero', $tiempo->Numero)->first();
        $this->idTiempo = $this->tiempoOR->id;
        $this->emit("idTiempo");
        $this->estado = 'inicio';

        event(new Enviar($this->estado));
    }

    public function fin($estado, $tiempoPieza)
    {
        if ($this->tiempoOR->id != '0') {
            $tiempo = TiemposOR::find($this->tiempoOR->id);
            if ($tiempo->Estado == 'pausa') {
                $this->finPausa();
            }
            $tiempo->Tiempo = $tiempoPieza;
            $tiempo->Estado = $estado;
            $tiempo->Fecha = date("y-m-d H:i:s");
            $tiempo->save();
        }

        foreach ($this->cambiosArticulos as $item) {
            $art = new DetalleReparacionArticulo();
            $art->NroOR=$this->ordenR->NroOR;
            $art->codArticulo= $item;
            $ag= ConjuntoArticulos::where('CodPieza',$this->ordenR->CodConjunto)
                                    ->where('CodArticulo',$item)->first();
            $art->Cantidad=$ag->Cantidad;
            $art->save();
        }
        foreach ($this->cambiosGomas as $item) {
            $goma = new DetalleReparacionGoma();
            $goma->NroOR = $this->ordenR->NroOR;
            $goma->CodGoma = $item;
            $g= ConjuntoGomas::where('CodigoGoma',$item)
                                ->where('CodPieza',$this->ordenR->CodConjunto)->first();
            $goma->Cantidad = $g->Cantidad;
            $goma->save();
        }
        foreach ($this->cambiosPiezas as $item) {
            $pieza = new DetalleReparacionPieza();
            $pieza->NroOR=$this->ordenR->NroOR;
            $pieza->codPieza=$item;
            $p = PiezaDeConjunto::where('codigoPieza',$item)
                                ->where('codigoCjto',$this->ordenR->CodConjunto)->first();
            $pieza->Cantidad= $p->Cantidad;
            $pieza->save();
        }
        
        //$this->cantidadPiezas();
        
        $or = OrdenReparacion::where('NroOR',$this->ordenR->NroOR)->first();
        $or->Estado = "finalizado";
        $or->save();
        event(new Enviar($this->maquina->CodMaquina));
        return redirect()->route('horarios.maquinas');
        
       /* if ($this->cantidad >= $this->detalleOE->Cantidad) {
            //$this->msj='ok';
            $detalle = OrdenEnsamble::find($this->ordenE->id);
            $detalle->Estado = 'finalizado';
            $detalle->save();
            

        }*/
    }

    public function pausa($tipo)
    {
        $pausa = new PausasOR();
        $pausa->Tipo = $tipo;
        $pausa->inicio = date("y-m-d H:i:s");
        $pausa->IdOR = $this->ordenR->id;
        $pausa->IdUsuario = auth()->user()->id;
        $pausa->saveOrFail();
        $this->pausa = $pausa;
        $this->estado = 'pausa';

        if ($this->tiempoOR->id != '0') {
            $tiempo = TiemposOR::find($this->tiempoOR->id);
            $tiempo->Estado = 'pausa';
            $tiempo->save();
            event(new Enviar($this->estado));
        }
    }

    public function finPausa()
    {
        if ($this->estado == 'pausa') {
            $pausa = PausasOR::where('IdOR', $this->ordenR->id)
                ->orderBy('id', 'DESC')->first();
            $pausa->Fin = date("y-m-d H:i:s");
            $pausa->saveOrFail();
            $this->estado = 'inicio';

            if ($this->tiempoOR->id != '0') {
                $tiempo = TiemposOR::find($this->tiempoOR->id);
                $tiempo->Estado = 'inicio';
                $tiempo->save();
                event(new Enviar($this->estado));
            }
        }
    }

    public function cantidadPiezas()
    {
        /*$piezas = TiemposOE::where('NroOE', $this->ordenE->NroOE)->get();
        $this->cantidad = count($piezas);*/
    }

    public function recarga($id)
    {
        $this->tiempoOR = TiemposOR::find($id);
        if ($this->tiempoOR != null) {
            $this->idTiempo = $this->tiempoOR->id;
            $this->estado = $this->tiempoOR->Estado;
        }
    }

}
