<?php

namespace App\Http\Controllers\Admin\Ordenes;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\ConjuntoArticulos;
use App\Models\ConjuntoGomas;
use App\Models\OrdenEnsamble;
use App\Models\OrdenEnsamblePendiente;
use App\Models\PiezaDeConjunto;
use Illuminate\Http\Request;

class EnsambleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        $conjuntos = Conjunto::all();
        return view('admin.ordenes.ensamble', compact('conjuntos'));
    }

    public function conjuntos()
    {
        $conjunto = request('conjunto');

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

        $ordenEnsamblePendiente = OrdenEnsamblePendiente::orderBy('NroOE', 'desc')->first();

        $ordenEnsamblePendiente2 = OrdenEnsamblePendiente::where('codigoCjto', $conjunto)
            ->orderBy('NroOE', 'desc')->first();

        $nroOE = $ordenEnsamblePendiente->NroOE + 1;
        $largo = strlen($nroOE);
        $nuevaOE = str_repeat('0', 8 - $largo);
        $nuevaOE .= $nroOE;

        $numero = $ordenEnsamblePendiente2->NroCjto + 1;

        $resultado = [
            'conjuntoArticulos' => $conjuntoArticulos, 'piezasConjunto' => $piezasConjunto,
            'conjuntoGomas' => $conjuntoGomas, 'nuevaOE' => $nuevaOE, 'numero' => $numero
        ];

        return json_encode($resultado);
    }

    public function guardar()
    {
        $conjunto = request('conjunto');
        $noe = request('noe');
        $numero = request('numero');
        $fecha = date('y-m-d');
        $fecha = str_replace('-', '', $fecha);
        $ordenEnsamblePendiente = new OrdenEnsamblePendiente();
        $ordenEnsamblePendiente->NroOE = $noe;
        $ordenEnsamblePendiente->fecha = $fecha;
        $ordenEnsamblePendiente->codigoCjto = $conjunto;
        $ordenEnsamblePendiente->NroCjto = $numero;
        $ordenEnsamblePendiente->Estado = 'A';
        $ordenEnsamblePendiente->saveOrFail();
        return json_encode('ok');
    }
    
/* Textos completos
id	
NroOE	
fecha	
codigoCjto	
NroCjto	
Estado */
}
