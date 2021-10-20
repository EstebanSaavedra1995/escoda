<?php

namespace App\Http\Controllers\Admin\Ordenes;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\ConjuntoArticulos;
use App\Models\ConjuntoGomas;
use App\Models\Construccion;
use App\Models\DetalleReparacionArticulo;
use App\Models\DetalleReparacionGoma;
use App\Models\DetalleReparacionPieza;
use App\Models\OrdenReparacion;
use App\Models\OrdenReparacionPendiente;
use App\Models\Personal;
use App\Models\PiezaDeConjunto;
use App\Models\PiezaOCStock;
use App\Models\TotalStockPiezas;
use Illuminate\Http\Request;

class ReparacionCompletarCancelarController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $supervisores = Personal::where('Cargo', 'Supervisor de ├ürea')
            ->where('Estado', 'A')->get();
        //Cambiar string cuando se cambie de base

        $operarios = Personal::Where('Estado', 'A')
            ->orwhere([
                ['Cargo', 'Operario Ayudante'],
                ['Cargo', 'Operario c/ Especializacion'],
                ['Cargo', 'Supervisor de ├ürea']
            ])->get();

        $ordenesPendientes = OrdenReparacionPendiente::orderBy('NroOR', 'desc')
            ->where('Estado', 'A')->get();
        return view('admin.ordenes.reparacioncompletarcancelar', compact(['ordenesPendientes', 'operarios', 'supervisores']));
    }

    public function ordenpendiente()
    {

        $conjunto = request('ordenes');
        $nroOrden = request('nroOrden');

        $ordenPendiente = OrdenReparacionPendiente::where('NroOR', $nroOrden)->first();

        $cjt = Conjunto::where('CodPieza', $conjunto)->first();
        $conjuntoArticulos = ConjuntoArticulos::select('*')
            ->join('articulosgenerales', 'conjuntoarticulosgenerales.CodArticulo', '=', 'articulosgenerales.CodArticulo')
            ->where('CodPieza', $conjunto)
            ->get();

        $piezasConjunto = PiezaDeConjunto::select('*')
            ->join('piezas', 'piezadeconjunto.codigoPieza', '=', 'piezas.CodPieza')
            ->where('CodigoCjto', $conjunto)
            ->get();

        $conjuntoGomas = ConjuntoGomas::select('*')
            ->join('gomas', 'conjuntogoma.CodigoGoma', '=', 'gomas.CodigoGoma')
            ->where('CodPieza', $conjunto)
            ->get();

        $resultado = [
            'conjuntoArticulos' => $conjuntoArticulos, 'piezasConjunto' => $piezasConjunto,
            'conjuntoGomas' => $conjuntoGomas, 'conjunto' => $cjt, 'ordenPendiente' => $ordenPendiente
        ];

        return json_encode($resultado);
    }

    public function ordenpieza()
    {
        $codigoPieza = request('codigoPieza');
        $ordenesConstruccion = Construccion::where('CodigoPieza', $codigoPieza)
            ->join('piezaocstock', 'ordenesconstruccion.NroOC', '=', 'piezaocstock.NroOC')
            ->where('ordenesconstruccion.CodigoPieza', $codigoPieza)
            ->where('piezaocstock.Stock', '>', 0)
            ->orderBy('ordenesconstruccion.NroOC', 'DESC')
            ->get();

        /* ->orderBy('NroOC', 'DESC')->get(); */

        return json_encode($ordenesConstruccion);
    }

    public function cancelarorden()
    {
        $orden = request('orden');
        $ordenPendiente = OrdenReparacionPendiente::where('NroOR', $orden)->first();
        $ordenPendiente->Estado = 'C';
        $ordenPendiente->saveOrFail();
        return json_encode('ok');
    }
    public function agregarorden()
    {
        $oc = request('oc');
        $oc = json_decode($oc);

        $ord = request('nro');
        $numero = request('numero');
        $op = request('op');
        $sup = request('sup');

        $gomasObj = request('gomasObj');
        $gomasObj = json_decode($gomasObj);

        $articulosObj = request('articulosObj');
        $articulosObj = json_decode($articulosObj);

        

        if (count($gomasObj) > 0) {
            foreach ($gomasObj as $g) {
                if ($g->opcion == '1') {
                    $goma = new DetalleReparacionGoma();
                    $goma->NroOR = $ord;
                    $goma->CodGoma = $g->id;
                    $goma->Cantidad = $g->cantidad;
                    $goma->saveOrFail();
                }
            }
        }

        if (count($articulosObj) > 0) {
            foreach ($articulosObj as $a) {
                if ($a->opcion == '1') {
                    $articulo = new DetalleReparacionArticulo();
                    $articulo->NroOR = $ord;
                    $articulo->codArticulo = $a->id;
                    $articulo->Cantidad = $a->cantidad;
                    $articulo->saveOrFail();
                }
            }
        }
  	

    
        if (count($oc) > 0) {
            foreach ($oc as $pieza) {
                foreach ($pieza->ordenes as $orden) {
                    $detalleReparacionPieza = new DetalleReparacionPieza();
                    $detalleReparacionPieza->NroOR = $ord;
                    $detalleReparacionPieza->codPieza = $pieza->id;
                    $detalleReparacionPieza->Cantidad = $orden->cantidad;
                    $detalleReparacionPieza->NroOC = $orden->orden;
                    $detalleReparacionPieza->saveOrFail();
                    $stockPieza = TotalStockPiezas::where('CodigoPieza', $pieza->id)->first();
                    $stockPieza->Stock = $stockPieza->Stock - $orden->cantidad;
                    $stockPieza->saveOrFail();
                    $piezaOCStock = PiezaOCStock::where('NroOC', $orden->orden)->first();
                    $piezaOCStock->Stock =$piezaOCStock->Stock - $orden->cantidad;
                    $piezaOCStock->saveOrFail();
                }
            }
        }
        $ordenPendiente = OrdenReparacionPendiente::where('NroOR', $ord)->first();
        $ordenPendiente->Estado = 'C';
        $ordenPendiente->saveOrFail();

        $fecha = date('Y-m-d');
        $orden = new OrdenReparacion();
        $orden->NroOR = $ord;
        $orden->Fecha = $fecha;
        $orden->CodConjunto = $ordenPendiente->codConjunto;
        $orden->NroCjto = $numero;
        $orden->NroLegajoOperario = $op;
        $orden->NroLegajoSupArea = $sup;
        $orden->Asignado = null;
        $orden->saveOrFail();

        return json_encode('ok');
    }
}
 