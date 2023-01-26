<?php

namespace App\Http\Controllers\Admin\Ordenes;

use App\Http\Controllers\Controller;
use App\Models\ArticulosGenerales;
use App\Models\Conjunto;
use App\Models\DetalleOE;
use App\Models\Goma;
use App\Models\Maquina;
use App\Models\Material;
use App\Models\OrdenEnsamble;
use App\Models\Pieza;
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
        $maquinas = Maquina::all();
        return view('admin.ordenes.ensamblelistar',compact('maquinas'));
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

        $pieza = Conjunto::where('CodPieza',$orden->codigoCjto)->first();

        $detalles = DetalleOE::where('NroOE', $id)->get();
        $resultado = [];
        foreach ($detalles as $detalle) {
            $aux = $this->buscarArticulos($detalle);
            if ($aux['tipo'] != 'nada') {
                $resultado[] = $aux;
            }
            /* $a = ArticulosGenerales::where('CodArticulo', $detalle->CodigoArticulo)->first();
            if ($a != null) {
                $resultadoA[] = $a;
            }

            $g = Goma::where('CodigoGoma', $detalle->CodigoArticulo)->first();
            if ($g != null) {
                $resultadoG[] = $g;
            }

            $p = Pieza::where('CodPieza', $detalle->CodigoArticulo)->first();
            if ($p != null) {
                $resultadoP[] = $p;
            } */
        }

        /* foreach ($resultado as $detalle) {
            echo json_encode($detalle) .'<br>';
        } */
        /* $resultado[] = [
            'orden' => $orden,
            'tareas' => $tareas
          ]; */
        //$resultado = $orden;
        //echo json_encode($resultado);
        return $this->enviarVistaPDF($orden, $detalles, $resultado,$pieza);
    }
    public function enviarVistaPDF($orden, $detalles, $resultado,$pieza)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('admin.ordenes.ordenEnsPDF', compact('orden', 'detalles', 'resultado','pieza'));
        $pdf->setPaper('A4');
        //$pdf->render();
        return $pdf->stream();
    }

    public function buscarArticulos($detalle)
    {
        $resultado= [
            'tipo' => 'nada'
        ];

        $a = ArticulosGenerales::where('CodArticulo', $detalle->CodigoArticulo)->first();
        if ($a != null) {
            $resultado = [
                'tipo' => 'articulo',
                'art' => $a,
                'detalle' => $detalle
            ];
        }

        $g = Goma::where('CodigoGoma', $detalle->CodigoArticulo)->first();
        if ($g != null) {
            $resultado = [
                'tipo' => 'goma',
                'art' => $g,
                'detalle' => $detalle
            ];
        }

        $p = Pieza::where('CodPieza', $detalle->CodigoArticulo)->first();
        if ($p) {
            $resultado = [
                'tipo' => 'pieza',
                'art' => $p,
                'detalle' => $detalle
            ];
        }

        return $resultado;
    }

    public function modificar(){
        $nroOE = request('nroOE');
        
        $orden = OrdenEnsamble::where('NroOE', $nroOE)->first();
        $detalle = DetalleOE::where('NroOE', $nroOE)->first();
        $conjunto = Conjunto::where('CodPieza',$orden->codigoCjto)->first();
        
        $resultado= [
            'orden' => $orden,
            'detalle' => $detalle,
            'conjunto' => $conjunto,
        ];
        
        return json_encode($resultado);
    }

    public function guardar(){
        $nroOE = request('nroOE');
        $orden = OrdenEnsamble::where('NroOE', $nroOE)->first();
        if (request('estado')) {
            $orden->Estado = request('estado');
        }else{

            $orden->Estado = "";
        }
        
        if (request('maquina')) {
            $orden->CodMaquina = request('maquina');
        }else{

            $orden->CodMaquina = "";
        }
        $orden->save();
        
        return json_encode("ok");
    }
}
