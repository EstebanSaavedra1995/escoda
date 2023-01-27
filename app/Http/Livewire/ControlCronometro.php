<?php

namespace App\Http\Livewire;

use App\Models\Conjunto;
use App\Models\DetalleOC;
use App\Models\Maquina;
use App\Models\OrdenEnsamble;
use App\Models\OrdenesConstruccion;
use App\Models\OrdenReparacion;
use App\Models\PausasOC;
use App\Models\PausasOE;
use App\Models\PausasOR;
use App\Models\Personal;
use App\Models\Pieza;
use App\Models\TiemposOC;
use App\Models\TiemposOE;
use App\Models\TiemposOR;
use App\Models\User;
use Request;
use Livewire\Component;

class ControlCronometro extends Component
{
    public $codMaquinas;
    public $cantidad;
    public $maquinas;
    public $ensambles;
    public $reparaciones;
    public $exitosas;
    public $fallidas;
    public $maquina;
    public $detalleOC;
    public $ordenC;
    public $evento;
    public $buscar;
    protected $listeners = ["recibido"];

    public function mount()
    {
        $this->maquinas = [];
        $this->ensambles = [];
        $this->reparaciones = [];
        $this->codMaquinas = [];
        $this->evento = '';
        $this->buscar = '';
        /* 
        $this->cantidad = '0';
        $this->exitosas = 0;
        $this->fallidas = 0;
        */
    }

    public function recibido($datos)
    {
        $this->evento = $datos;
        $this->cargarDatos();
        /*  if (!in_array($datos, $this->codMaquinas)) {
            $this->codMaquinas[] = $datos;
        }
        foreach ($this->codMaquinas as $cod) {
            $this->cargarDatos($cod);
        } */
    }

    public function render()
    {
        $this->cargarDatos();
        /* foreach ($this->codMaquinas as $cod) {
            $this->cargarDatos($cod);
        } */
        return view('livewire.control-cronometro');
    }

    public function cargarDatos()
    {
        unset($this->maquinas);
        $this->maquinas = [];
        //$codigos = Maquina::all();
        $detalles = DetalleOC::where('Estado', 'produccion')
            ->where('NroOC', 'LIKE', '%' . $this->buscar . '%')
            ->orderBy('Tarea', 'ASC')->get();
        $piezas = [];
        foreach ($detalles as $detalleOC) {
            //$cod = $value->CodMaquina;
            //$maquina = Maquina::where('CodMaquina', $cod)->first();
            //where('Maquina', 'like', '%' . $maquina->CodMaquina . '%')
            if ($detalleOC != null) {
                $cod = substr($detalleOC->Maquina, 0, 3);
                $maquina = Maquina::where('CodMaquina', $cod)->first();
                if ($maquina != null) {
                    $ordenC = OrdenesConstruccion::where('NroOC', $detalleOC->NroOC)->first();

                    $fallas = TiemposOC::where('idDetalleOC', $detalleOC->id)
                        ->where('Estado', 'fallida')->get();
                    $exitos = TiemposOC::where('idDetalleOC', $detalleOC->id)
                        ->where('Estado', 'exitosa')->get();

                    $total = TiemposOC::where('idDetalleOC', $detalleOC->id)->get();

                    $fallidas = count($fallas);
                    $exitosas = count($exitos);

                    $totales = count($total);

                    $ultima = TiemposOC::where('idDetalleOC', $detalleOC->id)
                    ->orderBy('id', 'DESC')->first();
                    
                    $pieza = Pieza::where('CodPieza', $ordenC->CodigoPieza)->first();

                        /* if ($ultima->idUsuario == '0') {
                            $operario = Personal::find(1);
                        } else { */
                            if ($ultima != null) {
                                $usuario = User::find($ultima->idUsuario);
                                $operario = Personal::find($usuario->NroLegajo);
                            } else {
                                $operario = Personal::find(1);
                            }
                            // }
                            
                    $pausa = null;
                    if ($ultima != null) {
                        $pausa = PausasOC::where('IdDetalleOC', $detalleOC->id)
                            ->orderBy('id', 'DESC')->first();
                    }
                    $zona = [
                        'maquina' => $maquina,
                        'detalleOC' => $detalleOC,
                        'ordenC' => $ordenC,
                        'fallidas' => $fallidas,
                        'exitosas' => $exitosas,
                        'total' => $totales,
                        'piezas' => $ultima,
                        'operario' => $operario,
                        'pausa' => $pausa,
                        'pieza' =>$pieza
                    ];

                    $piezas[] = $ultima;
                    $this->maquinas[] = $zona;
                }

                /* $inicios = TiemposOC::where('idDetalleOC', $detalleOC->id)
                ->where('Estado','inicio')->get(); */
                //if ($inicios != null) {
                //}
            }
        }
        $this->cargarEnsambles();
        $this->cargarReparaciones();
        $this->emit("inicios", json_encode($piezas));
    }

    function cargarEnsambles(){
        unset($this->reparaciones);
        $this->reparaciones = [];
        //$codigos = Maquina::all();
        $ordenes = OrdenReparacion::where('Estado', 'produccion')->get();
        $piezas = [];
        foreach ($ordenes as $orden) {
            if ($orden != null) {
                $maquina = Maquina::where('CodMaquina', $orden->CodMaquina)->first();
                if ($maquina != null) {
                    
                    $conjunto = Conjunto::where('CodPieza',$orden->CodConjunto)->first();
                    $tiempo = TiemposOR::where('NroOR',$orden->NroOR)->first();
                    $user = null;
                    if($tiempo != null){
                        $user = User::find($tiempo->idUsuario);
                    }

                    $pausa = PausasOR::where('IdOR', $orden->id)
                            ->orderBy('id', 'DESC')->first();
                    
                    $zona = [
                        'maquina' => $maquina,
                        'orden' => $orden,
                        'conjunto' => $conjunto,
                        'tiempo' => $tiempo,
                        'user' => $user,
                        'pausa' => $pausa
                    ];
                    $this->reparaciones[] = $zona;
                }

                /* $inicios = TiemposOC::where('idDetalleOC', $detalleOC->id)
                ->where('Estado','inicio')->get(); */
                //if ($inicios != null) {
                //}
            }
        }
    }
    
    function cargarReparaciones(){
        unset($this->ensambles);
        $this->ensambles = [];
        //$codigos = Maquina::all();
        $ordenes = OrdenEnsamble::where('Estado', 'produccion')->get();
        $piezas = [];
        foreach ($ordenes as $orden) {
            if ($orden != null) {
                $maquina = Maquina::where('CodMaquina', $orden->CodMaquina)->first();
                if ($maquina != null) {
                    
                    $conjunto = Conjunto::where('CodPieza',$orden->codigoCjto)->first();
                    $tiempo = TiemposOE::where('NroOE',$orden->NroOE)->first();
                    $user = null;
                    if($tiempo != null){
                        $user = User::find($tiempo->idUsuario);
                    }

                    $pausa = PausasOE::where('IdOE', $orden->id)
                            ->orderBy('id', 'DESC')->first();
                    
                    $zona = [
                        'maquina' => $maquina,
                        'orden' => $orden,
                        'conjunto' => $conjunto,
                        'tiempo' => $tiempo,
                        'user' => $user,
                        'pausa' => $pausa
                    ];
                    $this->ensambles[] = $zona;
                }

                /* $inicios = TiemposOC::where('idDetalleOC', $detalleOC->id)
                ->where('Estado','inicio')->get(); */
                //if ($inicios != null) {
                //}
            }
        }
    }
}
