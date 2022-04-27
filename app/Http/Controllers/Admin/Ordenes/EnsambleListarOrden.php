<?php

namespace App\Http\Controllers\Admin\Ordenes;

use App\Http\Controllers\Controller;
use App\Models\OrdenEnsamble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class EnsambleListarOrden extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.ordenes.ensamblelistar');
    }
    public function listarordenes()
    {

        $tipo = request('lista');

        if ($tipo == 0) {
            $nroOrden = request('nroorden');
            $ordenes = OrdenEnsamble::select('*')
                ->join('conjuntos', 'ordenesensamble.codigoCjto', '=', 'conjuntos.CodPieza')
                ->where('NroOE', 'LIKE', '%' . $nroOrden . '%')->get();
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


            $ordenes = OrdenEnsamble::select('*')
                ->join('conjuntos', 'ordenesensamble.codigoCjto', '=', 'conjuntos.CodPieza')
                ->whereBetween('ordenesensamble.fecha', [$fecha1, $fecha2])->get();
            $rta = [];
            $rta[] = 'fechas';
            $rta[] = $ordenes;
            return json_encode($rta);
        } else {
            $herramienta = request('herramienta');
            $ordenes = OrdenEnsamble::select('*')
                ->join('conjuntos', 'ordenesensamble.codigoCjto', '=', 'conjuntos.CodPieza')
                ->where('ordenesensamble.codigoCjto', $herramienta)->get();
            $rta = [];
            $rta[] = 'herramientas';
            $rta[] = $ordenes;
            return json_encode($rta);
        }
    }

    public function ordenEnsPDF() 
    {
        $id = request('idPDF');

        $orden = OrdenEnsamble::where('NroOE', $id)->first();
        $fecha = date_create($orden->Fecha);
        $fecha = date_format($fecha, "d/m/Y");
        $orden->Fecha = $fecha;

        /* $pieza = Pieza::where('CodPieza',$orden->CodigoPieza)->first();

        $material= Material::where('CodigoMaterial',$orden->CodigoMaterial)->first();

        $tareas = DetalleOC::where('NroOC', $id)
            ->orderBy('Renglon', 'ASC')
            ->get(); */

        /* $resultado[] = [
            'orden' => $orden,
            'tareas' => $tareas
          ]; */
        //$resultado = $orden;
        return $this->enviarVistaPDF($orden);
    }
    public function enviarVistaPDF($orden)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('admin.ordenes.ordenEnsPDF', compact('orden'));
        return $pdf->stream();
    }
}
