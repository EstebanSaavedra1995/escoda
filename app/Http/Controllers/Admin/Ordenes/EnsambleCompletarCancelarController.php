<?php

namespace App\Http\Controllers\Admin\Ordenes;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\ConjuntoArticulos;
use App\Models\ConjuntoGomas;
use App\Models\OrdenEnsamblePendiente;
use App\Models\Personal;
use App\Models\PiezaDeConjunto;
use Illuminate\Http\Request;

class EnsambleCompletarCancelarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $supervisores = Personal::where('Cargo', 'Supervisor de Área')
            ->where('Estado', 'A')->get();

        $operarios = Personal::Where('Estado', 'A')
            ->orwhere([
                ['Cargo', 'Operario Ayudante'],
                ['Cargo', 'Operario c/ Especializacion'],
                ['Cargo', 'Supervisor de Área']
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
}
