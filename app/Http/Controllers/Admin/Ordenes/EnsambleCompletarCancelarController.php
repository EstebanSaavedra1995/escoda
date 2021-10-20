<?php

namespace App\Http\Controllers\Admin\Ordenes;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\ConjuntoArticulos;
use App\Models\ConjuntoGomas;
use App\Models\Construccion;
use App\Models\DetalleOE;
use App\Models\OrdenEnsamble;
use App\Models\OrdenEnsamblePendiente;
use App\Models\Personal;
use App\Models\PiezaDeConjunto;
use App\Models\PiezaOCStock;
use App\Models\TotalStockPiezas;
use Illuminate\Http\Request;

class EnsambleCompletarCancelarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $supervisores = Personal::where('Cargo', 'Supervisor de ├ürea')
            ->where('Estado', 'A')->get();

        $operarios = Personal::Where('Estado', 'A')
            ->orwhere([
                ['Cargo', 'Operario Ayudante'],
                ['Cargo', 'Operario c/ Especializacion'],
                ['Cargo', 'Supervisor de ├ürea']
            ])->get();

        $ordenesPendientes = OrdenEnsamblePendiente::orderBy('NroOE', 'desc')
            ->where('Estado', 'A')->get();
        return view('admin.ordenes.ensamblecompletarcancelar', compact(['ordenesPendientes', 'operarios', 'supervisores']));
    }
    public function ordenpendiente()
    {

        $conjunto = request('ordenes');
        $nroOrden = request('nroOrden');

        $ordenPendiente = OrdenEnsamblePendiente::where('NroOE', $nroOrden)->first();

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

    public function cancelarorden()
    {
        $orden = request('orden');
        $ordenPendiente = OrdenEnsamblePendiente::where('NroOE', $orden)->first();
        $ordenPendiente->Estado = 'C';
        $ordenPendiente->save();
        return json_encode('ok');
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
                    $detalleOE = new DetalleOE();
                    $detalleOE->NroOE = $ord;
                    $detalleOE->CodigoArticulo = $g->id;
                    $detalleOE->Cantidad = $g->cantidad;
                    $detalleOE->OC = "-";
                    $detalleOE->saveOrFail();
                }
            }
        }

        if (count($articulosObj) > 0) {
            foreach ($articulosObj as $a) {
                if ($a->opcion == '1') {
                    $detalleOE = new DetalleOE();
                    $detalleOE->NroOE = $ord;
                    $detalleOE->CodigoArticulo = $a->id;
                    $detalleOE->Cantidad = $a->cantidad;
                    $detalleOE->OC = "-";
                    $detalleOE->saveOrFail();
               
                }
            }
        }
  	

    
        if (count($oc) > 0) {
            foreach ($oc as $pieza) {
                foreach ($pieza->ordenes as $orden) {

                    $detalleOE = new DetalleOE();
                    $detalleOE->NroOE = $ord;
                    $detalleOE->CodigoArticulo = $pieza->id;
                    $detalleOE->Cantidad = $orden->cantidad;
                    $detalleOE->OC = $orden->orden;
                    $detalleOE->saveOrFail();
            
                    $stockPieza = TotalStockPiezas::where('CodigoPieza', $pieza->id)->first();
                    $stockPieza->Stock = $stockPieza->Stock - $orden->cantidad;
                    $stockPieza->saveOrFail();

                    $piezaOCStock = PiezaOCStock::where('NroOC', $orden->orden)->first();
                    $piezaOCStock->Stock =$piezaOCStock->Stock - $orden->cantidad;
                    $piezaOCStock->saveOrFail(); 
                }
            }
        }


     
        
        $ordenPendiente = OrdenEnsamblePendiente::where('NroOE', $ord)->first();
        $ordenPendiente->Estado = 'C';
        $ordenPendiente->saveOrFail();

        $fecha = date('Y-m-d');
        $orden = new OrdenEnsamble();
        $orden->NroOE = $ord;
        $orden->fecha = $fecha;
        $orden->codigoCjto = $ordenPendiente->codigoCjto;
        $orden->NroCjto = $ordenPendiente->NroCjto;
        $orden->Operario = $op;
        $orden->Supervisor = $sup;
        $orden->saveOrFail();
       
        return json_encode('ok');
    }
    


}
