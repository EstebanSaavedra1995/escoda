<?php

namespace App\Http\Controllers\Admin\Ordenes;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\OrdenReparacion;
use Illuminate\Http\Request;

class ListarOrdenReparacion extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.ordenes.reparacionlistar');
    }
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
        } else {
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
        return json_encode($nro);
    }
}
