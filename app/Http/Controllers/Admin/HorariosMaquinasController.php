<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetalleOC;
use App\Models\Maquina;
use App\Models\Material;
use App\Models\OrdenEnsamble;
use App\Models\OrdenesConstruccion;
use App\Models\OrdenReparacion;
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

        $ordenesR = OrdenReparacion::where('ordenesreparacion.CodMaquina', $id)
        ->join('conjuntos', 'conjuntos.CodPieza', '=', 'ordenesreparacion.CodConjunto')
        ->where('ordenesreparacion.Estado', 'produccion')->get();
        
        $ordenesE = OrdenEnsamble::where('ordenesensamble.CodMaquina', $id)
        ->join('conjuntos', 'conjuntos.CodPieza', '=', 'ordenesensamble.codigoCjto')
        ->where('ordenesensamble.Estado', 'produccion')->get();
        //echo json_encode($ordenesR);
        return view('admin.ControlTiempos.tiempos', compact(['ordenesC','ordenesE','ordenesR']));
    }

    public function marcarTiempos()
    {
        $idTarea = request('id');
        $tipo = "oc";
        return view('admin.ControlTiempos.tiemposMarcar', compact(['idTarea','tipo']));
    }
    
    public function marcarTiemposEnsamble()
    {
        $idTarea = request('id');
        $tipo = "oe";
        return view('admin.ControlTiempos.tiemposMarcar', compact(['idTarea','tipo']));
    }
    
    public function marcarTiemposReparacion()
    {
        $idTarea = request('id');
        $tipo = "or";
        return view('admin.ControlTiempos.tiemposMarcar', compact(['idTarea','tipo']));
    }
}
