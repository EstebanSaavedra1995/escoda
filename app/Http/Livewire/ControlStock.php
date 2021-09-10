<?php

namespace App\Http\Livewire;

use App\Models\ArticulosGenerales;
use App\Models\ColadaMaterial;
use App\Models\Goma;
use App\Models\Material;
use App\Models\OrdenesConstruccion;
use App\Models\Pieza;
use App\Models\PiezaOCStock;
use Livewire\Component;

class ControlStock extends Component
{
    public $tipo;

    public $datos;

    public $buscar;

    public $detalles;

    public function mount()
    {
        $this->tipo = 'materiales';
        $this->buscar = '';
        $this->datos = Material::all();
        unset($this->detalles);
        $this->detalles = [];
    }

    public function render()
    {

        $this->cambiarDatos();
        return view('livewire.control-stock');
    }

    public function llenarTabla($tipoTabla)
    {
        $this->tipo = $tipoTabla;
        unset($this->detalles);
        $this->detalles = [];
        $this->buscar = '';
        //$this->cambiarDatos();
    }

    public function cambiarDatos()
    {
        /* unset($this->detalles);
        $this->detalles = []; */
        switch ($this->tipo) {
            case 'materiales':
                $this->datos = Material::where('CodigoMaterial', 'LIKE', '%' . $this->buscar . '%')
                    ->orwhere('Material', 'LIKE', '%' . $this->buscar . '%')->get();
                break;
            case 'gomas':
                $this->datos = Goma::where('CodigoGoma', 'LIKE', '%' . $this->buscar . '%')
                    ->orwhere('CodigoInterno', 'LIKE', '%' . $this->buscar . '%')->get();
                break;
            case 'articulos':
                $this->datos = ArticulosGenerales::where('CodArticulo', 'LIKE', '%' . $this->buscar . '%')
                    ->orwhere('Descripcion', 'LIKE', '%' . $this->buscar . '%')->get();;
                break;
            case 'piezas':
                $this->datos = Pieza::where('CodPieza', 'LIKE', '%' . $this->buscar . '%')
                    ->orwhere('NombrePieza', 'LIKE', '%' . $this->buscar . '%')->get();;
                break;
        }
    }

    public function cargarDetalles($cod)
    {
        unset($this->detalles);
        $this->detalles = [];

        switch ($this->tipo) {
            case 'materiales':
                $this->detalles = ColadaMaterial::where('CodigoMaterial', $cod)->get();
                break;

            case 'piezas':
                /* $ordenes = OrdenReparacion::select('*')
                ->join('conjuntos', 'ordenesreparacion.CodConjunto', '=', 'conjuntos.CodPieza')
                ->join('personal', 'ordenesreparacion.NroLegajoOperario', '=', 'personal.NroLegajo')
                ->where('NroOR', 'LIKE', '%' . $nroOrden . '%')->get(); */

                $ordenes = OrdenesConstruccion::select('*')
                ->join('piezaocstock', 'ordenesconstruccion.NroOC', '=', 'piezaocstock.NroOC')
                ->where('CodigoPieza', $cod)->get();

                if (!$ordenes == null) {
                    $this->detalles = $ordenes;
                }
                /* foreach ($ordenes as $orden) {
                    $stock = PiezaOCStock::where('NroOC', $orden->NroOC)->first();
                    if (!$stock == null) {
                        $this->detalles[] = $stock;
                    }
                } */
                break;
            default:
            unset($this->detalles);
            $this->detalles = [];
                break;
        }
    }
}
