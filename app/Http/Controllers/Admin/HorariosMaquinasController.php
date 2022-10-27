<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetalleOC;
use App\Models\Maquina;
use App\Models\Material;
use App\Models\OrdenesConstruccion;
use App\Models\TiemposOC;
use Request;

class HorariosMaquinasController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = Request::cookie('maquina');
        $ordenesC = DetalleOC::where('detalleoc.Maquina', 'like', '%' . $id . '%')
            ->join('ordenesconstruccion', 'detalleoc.NroOC', '=', 'ordenesconstruccion.NroOC')
            ->join('piezas', 'ordenesconstruccion.CodigoPieza', '=', 'piezas.CodPieza')
            ->select('ordenesconstruccion.*','piezas.*','detalleoc.*','detalleoc.id as detalleID')
            ->where('detalleoc.Estado', 'produccion')->get();
        //echo json_encode($ordenesC);
        return view('admin.ControlTiempos.tiempos', compact('ordenesC'));
    }

    public function marcarTiempos()
    {
        $idTarea = request('id');
        /* $idMaq = Request::cookie('maquina');

        $maquina = Maquina::where('CodMaquina', $idMaq)->first();
        $tarea = DetalleOC::find($idTarea);

        if ($tarea != null) {

            $ordenC = OrdenesConstruccion::where('NroOC', $tarea->NroOC)->first();

            $material = Material::where('CodigoMaterial', $ordenC->CodigoMaterial)->first();

            $fallas = TiemposOC::where('idDetalleOC', $tarea->id)
                ->where('Estado', 'fallida')->get();
            $exitos = TiemposOC::where('idDetalleOC', $tarea->id)
                ->where('Estado', 'exitosa')->get();

            $fallidas = count($fallas);
            $exitosas = count($exitos);

            $cantidad = $fallidas + $exitosas;
        } */

        return view('admin.ControlTiempos.tiemposMarcar', compact(['idTarea']));
    }
}
