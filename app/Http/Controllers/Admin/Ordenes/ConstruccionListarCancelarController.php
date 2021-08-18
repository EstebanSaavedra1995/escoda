<?php

namespace App\Http\Controllers\Admin\Ordenes;


use App\Http\Controllers\Controller;
use App\Models\ColadaMaterial;
use App\Models\Construccion;
use App\Models\DetalleOC;
use App\Models\Material;
use App\Models\Pieza;
use App\Models\PiezaOCStock;
use App\Models\TotalStockMateriales;
use App\Models\TotalStockPiezas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OCExport;
use App\Exports\OCFechasExport;
use App\Exports\OCNumeroExport;

class ConstruccionListarCancelarController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('admin.ordenes.listarcancelar');
    }
    public function piezas()
    {
        $piezas = Pieza::all();
        return json_encode($piezas);
    }

    public function ordenes()
    {
        $tipo = request('lista');

        if ($tipo == 0) {

            $nroOrden = request('nroorden');
            $ordenes = Construccion::select('*')
                ->join('materiales', 'ordenesconstruccion.CodigoMaterial', '=', 'materiales.CodigoMaterial')
                ->join('piezas', 'ordenesconstruccion.CodigoPieza', '=', 'piezas.CodPieza')
                ->where('Estado', 'A')
                ->where('NroOC', 'LIKE', '%' . $nroOrden . '%')->get();
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

            $ordenes = Construccion::select('*')
                ->join('materiales', 'ordenesconstruccion.CodigoMaterial', '=', 'materiales.CodigoMaterial')
                ->join('piezas', 'ordenesconstruccion.CodigoPieza', '=', 'piezas.CodPieza')
                ->where('Estado', 'A')
                ->whereBetween('Fecha', [$fecha1, $fecha2])->get();
            $rta = [];
            $rta[] = 'fechas';
            $rta[] = $ordenes;
            return json_encode($rta);
        } else {
            $pieza = request('pieza');
            $ordenes = Construccion::select('*')
                ->join('materiales', 'ordenesconstruccion.CodigoMaterial', '=', 'materiales.CodigoMaterial')
                ->join('piezas', 'ordenesconstruccion.CodigoPieza', '=', 'piezas.CodPieza')
                ->where('Estado', 'A')
                ->where('CodigoPieza', $pieza)->get();
            $rta = [];
            $rta[] = 'piezas';
            $rta[] = $ordenes;
            return json_encode($rta);
        }
    }

    public function detalles()
    {
        $oc = request('oc');
        $detallesOC = DetalleOC::where('NroOC', $oc)->get();
        return json_encode($detallesOC);
    }
    public function cancelar()
    {
        $oc = request('numoc');

        $ordenConstruccion = Construccion::where('NroOC', $oc)->first();
        $pieza = $ordenConstruccion->CodigoPieza;
        $cantidadRealizar = $ordenConstruccion->Cantidad;
        $idMaterial = $ordenConstruccion->CodigoMaterial;
        $colada = $ordenConstruccion->Colada;
        $longitudCorte = $ordenConstruccion->LongitudCorte;
        $cantidadMaterial = ($longitudCorte * $cantidadRealizar) / 1000;



        $piezaOCStock = PiezaOCStock::where('NroOC', $oc)->first();
        $piezaOCStock->Stock = 0;
        $piezaOCStock->saveOrFail();

        $coladaMaterial = ColadaMaterial::where('CodigoMaterial', $idMaterial)
            ->where('Colada', $colada)->first();
        $coladaMaterial->Stock = $coladaMaterial->Stock + $cantidadMaterial;
        $coladaMaterial->saveOrFail();

        $materiales = Material::where('CodigoMaterial', $idMaterial)->first();
        $materiales->Stock = $materiales->Stock + $cantidadMaterial;
        $materiales->saveOrFail();

        $totalStockPiezas = TotalStockPiezas::where('CodigoPieza', $pieza)->first();
        $totalStockPiezas->Stock = $totalStockPiezas->Stock - $ordenConstruccion->Cantidad;
        $totalStockPiezas->saveOrFail();

        $totalStockMateriales = TotalStockMateriales::where('CodigoMaterial', $idMaterial)->first();
        $totalStockMateriales->Stock = $totalStockMateriales->Stock + $cantidadMaterial;
        $totalStockMateriales->saveOrFail();

        $ordenConstruccion->Estado = 'C';
        $ordenConstruccion->save();
        return json_encode('ok');
    }


    public function exportExcel()
    {
        $piezaExcel = request('piezaExcel');
        return Excel::download(new OCExport($piezaExcel), 'ocpieza_' . $piezaExcel . '.xlsx');
    }

    public function exportExcelFechas()
    {
        $fecha1 = request('fecha1Excel');
        $fecha2 = request('fecha2Excel');
        return Excel::download(new OCFechasExport($fecha1, $fecha2), 'ocfechas_' . $fecha1 . '_' . $fecha2 . '.xlsx');
    }
    public function exportExcelNumero()
    {
        $numeroExcel = request('numeroExcel');
        return Excel::download(new OCNumeroExport($numeroExcel), 'ocnumeros_' . $numeroExcel . '.xlsx');
    }
}
