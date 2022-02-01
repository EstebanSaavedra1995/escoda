<?php

namespace App\Http\Controllers\Admin\Ordenes;

use App\Exports\ORExport;
use App\Exports\ORFechasExport;
use App\Exports\ORNumeroExport;
use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\ConjuntoArticulos;
use App\Models\ConjuntoGomas;
use App\Models\Construccion;
use App\Models\DetalleReparacionArticulo;
use App\Models\DetalleReparacionGoma;
use App\Models\DetalleReparacionPieza;
use App\Models\OrdenReparacion;
use App\Models\Pieza;
use App\Models\PiezaDeConjunto;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class ReparacionListarOrden extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
      /*   $ordenes = Construccion::select('id', 'NroOC')->orderBy('NroOC', 'DESC')->get();
        $piezas = Pieza::select('CodPieza', 'NombrePieza', 'Medida')->orderBy('CodPieza', 'asc')->get(); */
        $conjuntos = Conjunto::all();
        $ordenes = OrdenReparacion::select('id', 'NroOR')->orderBy('NroOR', 'DESC')->get();
        return view('admin.ordenes.reparacionlistar', compact(['ordenes','conjuntos']));
    }
    /* public function index()
    {
        return view('admin.ordenes.reparacionlistar');
    } */
    public function listarherramientas()
    {
        $conjuntos = Conjunto::all();
        return json_encode($conjuntos);
    }
    public function listarordenes()
    {

        $tipo = request('lista');

        if ($tipo == 0) {
            $nroOrden = request('nroorden');
            $ordenes = OrdenReparacion::select('*')
                ->join('conjuntos', 'ordenesreparacion.CodConjunto', '=', 'conjuntos.CodPieza')
                ->join('personal', 'ordenesreparacion.NroLegajoOperario', '=', 'personal.NroLegajo')
                ->where('NroOR', 'LIKE', '%' . $nroOrden . '%')->get();
            $rta = [];
            $rta[] = 'ordenes';
            $rta[] = $ordenes;
            return json_encode($rta);
        } elseif ($tipo == 1) {

            $fecha1 = request('fecha1');
            $fecha2 = request('fecha2');
            $fecha1 = str_replace('-', '', $fecha1);
            $fecha2 = str_replace('-', '', $fecha2);
            $fecha1 = substr($fecha1, -6);
            $fecha2 = substr($fecha2, -6);

            $ordenes = OrdenReparacion::select('*')
                ->join('conjuntos', 'ordenesreparacion.CodConjunto', '=', 'conjuntos.CodPieza')
                ->join('personal', 'ordenesreparacion.NroLegajoOperario', '=', 'personal.NroLegajo')
                ->whereBetween('ordenesreparacion.Fecha', [$fecha1, $fecha2])->get();
            $rta = [];
            $rta[] = 'fechas';
            $rta[] = $ordenes;
            return json_encode($rta);
        } elseif ($tipo == 2) {
            $herramienta = request('herramienta');
            $ordenes = OrdenReparacion::select('*')
                ->join('conjuntos', 'ordenesreparacion.CodConjunto', '=', 'conjuntos.CodPieza')
                ->join('personal', 'ordenesreparacion.NroLegajoOperario', '=', 'personal.NroLegajo')
                ->where('ordenesreparacion.CodConjunto', $herramienta)->get();
            $rta = [];
            $rta[] = 'herramientas';
            $rta[] = $ordenes;
            return json_encode($rta);
        }
    }
    public function listardetalles()
    {
        $nro = request('nro');
        $detallesArticulos = DetalleReparacionArticulo::select('*')
            ->join('articulosgenerales', 'detallereparacionarticulos.codArticulo', '=', 'articulosgenerales.CodArticulo')
            ->where('NroOR', $nro)->get();

        $detalleGomas = DetalleReparacionGoma::select('*')
            ->join('gomas', 'detallereparaciongomas.CodGoma', '=', 'gomas.CodigoGoma')
            ->where('NroOR', $nro)->get();

        $detallePiezas = DetalleReparacionPieza::select('*')
            ->join('piezas', 'detallereparacionpiezas.codPieza', '=', 'piezas.CodPieza')
            ->where('NroOR', $nro)->get();

        $rta = [];
        $rta[] = $detallesArticulos;
        $rta[] = $detalleGomas;
        $rta[] = $detallePiezas;
        return json_encode($rta);
    }

    public function modificarorden()
    {
        
        $nroOrden = request('or');
        $orden = OrdenReparacion::where('NroOR', $nroOrden)->first();

        $conjunto = $orden->CodConjunto;

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
            'conjuntoGomas' => $conjuntoGomas, 'conjunto' => $cjt, 'orden' => $orden
        ];

        return json_encode($resultado);
    }
  /*   public function exportExcel()
    {
        $piezaExcel = request('piezaExcel');
        return Excel::download(new ORExport($piezaExcel), 'orpieza_' . $piezaExcel . '.xlsx');
    }

    public function exportExcelFechas()
    {
        $fecha1 = request('fecha1Excel');
        $fecha2 = request('fecha2Excel');
        return Excel::download(new ORFechasExport($fecha1, $fecha2), 'orfechas_' . $fecha1 . '_' . $fecha2 . '.xlsx');
    }
    public function exportExcelNumero()
    {
        $numeroExcel = request('numeroExcel');
        return Excel::download(new ORNumeroExport($numeroExcel), 'ornumeros_' . $numeroExcel . '.xlsx');
    } */
}
