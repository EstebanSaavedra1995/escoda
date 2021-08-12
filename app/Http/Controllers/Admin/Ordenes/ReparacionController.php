<?php

namespace App\Http\Controllers\Admin\Ordenes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Conjunto;
use App\Models\ConjuntoArticulos;
use App\Models\ConjuntoGomas;
use App\Models\OrdenReparacionPendiente;
use App\Models\PiezaDeConjunto;

class ReparacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $conjuntos = Conjunto::all();
        return view('admin.ordenes.reparacion', compact('conjuntos'));
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

        $orpendientes = OrdenReparacionPendiente::orderBy('NroOR', 'desc')->first();

        $nroOR = $orpendientes->NroOR + 1;
        $largo = strlen($nroOR);
        $nuevaOR = str_repeat('0', 8 - $largo);
        $nuevaOR .= $nroOR;

        $resultado = [
            'conjuntoArticulos' => $conjuntoArticulos, 'piezasConjunto' => $piezasConjunto,
            'conjuntoGomas' => $conjuntoGomas, 'nuevaor' => $nuevaOR
        ];

        return json_encode($resultado);
        /*     if ($conjuntoArticulos && $piezasConjunto && $orpendientes) {
            $resultado = [
                'articulosgenerales' => $conjuntoArticulos, 'piezaconjunto' => $piezasConjunto,
                'nuevaor' => $nuevaOR
            ];

            return json_encode($resultado);
        } else {
            $resultado = [];
            return json_encode($resultado);
        } */
    }

    public function guardar()
    {
        $conjunto = request('conjunto');
        $nor = request('nor');
        $fecha = date('y-m-d');
        $fecha = str_replace('-', '', $fecha);
        $orpendientes = new OrdenReparacionPendiente();
        $orpendientes->NroOR = $nor;
        $orpendientes->codConjunto = $conjunto;
        $orpendientes->Fecha = $fecha;
        $orpendientes->Estado = 'A';
        $orpendientes->saveOrFail();
        return json_encode('ok');
    }
  
}
