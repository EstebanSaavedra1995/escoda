<?php

namespace App\Http\Livewire;

use App\Models\DetalleOC;
use App\Models\Maquina;
use App\Models\OrdenesConstruccion;
use App\Models\Personal;
use App\Models\TiemposOC;
use App\Models\User;
use Request;
use Livewire\Component;

class ControlCronometro extends Component
{
    public $codMaquinas;
    public $cantidad;
    public $maquinas;
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


                    /* if ($ultima->idUsuario == '0') {
                        $operario = Personal::find(1);
                    } else { */
                    if ($ultima != null) {
                        $usuario = User::find($ultima->idUsuario);
                        $operario = Personal::find($usuario->NroLegajo);
                    }
                    else
                    {
                        $operario = Personal::find(1);

                    }
                    // }

                    $zona = [
                        'maquina' => $maquina,
                        'detalleOC' => $detalleOC,
                        'ordenC' => $ordenC,
                        'fallidas' => $fallidas,
                        'exitosas' => $exitosas,
                        'total' => $totales,
                        'piezas' => $ultima,
                        'operario' => $operario,
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
        $this->emit("inicios", json_encode($piezas));
    }
}
