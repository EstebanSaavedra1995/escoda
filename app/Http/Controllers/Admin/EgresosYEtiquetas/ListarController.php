<?php

namespace App\Http\Controllers\Admin\EgresosYEtiquetas;

use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\TrazabilidadConjuntos;
use App\Models\Conjunto;
use App\Models\Pieza;
use Illuminate\Http\Request;

class ListarController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('admin/egresosYEtiquetas/listar');
    }
    public function piezas()
    {
        if (request()->getMethod() == 'POST') {
            $check = request('ck');

            if ($check == 'piezas') {

                $piezas = Pieza::all();
                //$materialPieza = MaterialPieza::all();
                $resultado = [
                    'piezas' => $piezas,
                    'materialPieza' => null
                ];
            }

            if ($check == 'conjuntos') {
                $conjunto = Conjunto::all();
                //$piezaConjunto = PiezaDeConjunto::all();
                $resultado = [
                    'conjunto' => $conjunto,
                    'piezaConjunto' => null
                ];
            }

            return json_encode($resultado);
        }
    }
    public function tabla()
    {
        if (request()->getMethod() == 'POST') {
            $listar = request('listarPor');
            $trazabilidad = "";
            switch ($listar) {
                case '0':
                    $trazabilidad = TrazabilidadConjuntos::all();
                    break;
                case 'nroDeEgreso':
                    $nroEgreso = request('nroEgreso');
                    if ($nroEgreso != "0") {
                        $nroEgreso = str_pad($nroEgreso, 8, "0", STR_PAD_LEFT);
                        $trazabilidad = TrazabilidadConjuntos::where('NroEgreso', $nroEgreso)->get();
                    } else {
                        $trazabilidad = TrazabilidadConjuntos::all();
                    }
                    break;
                case 'fecha':
                    $fechaDesde = request('fechaDesde');
                    $fechaDesde = date_create($fechaDesde);
                    $fechaDesde = date_format($fechaDesde, "y-m-d");
                    $fechaHasta = request('fechaHasta');
                    $fechaHasta = date_create($fechaHasta);
                    $fechaHasta = date_format($fechaHasta, "y-m-d");
                    $trazabilidad = TrazabilidadConjuntos::where('Fecha', '>=', $fechaDesde)
                        ->where('Fecha', '<=', $fechaHasta)->get();
                    break;
                case 'pieza':
                    $pieza = request('piezasMod');
                    $nro = request('nroMod');
                    $fechaDesdePieza = request('fechaDesdePieza');
                    $fechaDesdePieza = date_create($fechaDesdePieza);
                    $fechaDesdePieza = date_format($fechaDesdePieza, "ymd");
                    $fechaHastaPieza = request('fechaHastaPieza');
                    $fechaHastaPieza = date_create($fechaHastaPieza);
                    $fechaHastaPieza = date_format($fechaHastaPieza, "ymd");
                    if ($pieza == 0) {
                        $trazabilidad = TrazabilidadConjuntos::where('Fecha', '>=', $fechaDesdePieza)
                            ->where('Fecha', '<=', $fechaHastaPieza)->get();
                    } else {
                        if ($nro == 0) {
                            $trazabilidad = TrazabilidadConjuntos::where('Fecha', '>=', $fechaDesdePieza)
                                ->where('Fecha', '<=', $fechaHastaPieza)
                                ->where('CodPieza', $pieza)->get();
                        } else {
                            $nro = str_pad($nro, 8, "0", STR_PAD_LEFT);
                            $trazabilidad = TrazabilidadConjuntos::where('Fecha', '>=', $fechaDesdePieza)
                                ->where('Fecha', '<=', $fechaHastaPieza)
                                ->where('CodPieza', $pieza)
                                ->where('Numero', $nro)->get();
                        }
                    }
                    break;
            }

            foreach ($trazabilidad as $value) {

                $fecha = date_create($value->Fecha);
                $fecha = date_format($fecha, "d/m/Y");
                $value->Fecha = $fecha;

                if ($value->FechaIntervencion != "__/__/__") {
                    /* $fecha = date_create($value->FechaIntervencion);
                    $fecha = date_format($fecha, "d/m/Y");
                    $value->FechaIntervencion = $fecha; */
                } else {
                    $value->FechaIntervencion = '-';
                }

                if ($value->NroOR == null) {
                    $value->NroOR = '-';
                }

                if ($value->NroEgreso == null) {
                    $value->NroEgreso = '-';
                }

                if ($value->Pozo == null) {
                    $value->Pozo = '-';
                }
            }

            return json_encode($trazabilidad);
        }
    }

    public function modificar()
    {
        if (request()->getMethod() == 'POST') {

            $id = request('idMod');
            $nroE = request('nroEMod');
            $fechaE = request('FechaEMod');
            $condicion = request('condicionMod');
            $tipo = request('tipoMod');
            $fechaI = request('FechaIMod');
            $pozo = request('pozoMod');
            $nroOR = request('nroORMod');

            $trazabilidad = TrazabilidadConjuntos::where('id', $id)->first();
            $trazabilidad->NroEgreso = $nroE;
            $trazabilidad->Fecha = $fechaE;
            $trazabilidad->Condicion = $condicion;
            $trazabilidad->TipoEgreso = $tipo;
            $trazabilidad->FechaIntervencion = $fechaI;
            $trazabilidad->Pozo = $pozo;
            $trazabilidad->NroOR = $nroOR;
            $trazabilidad->save();
            return json_encode(" ");
        }
    }

    public function eliminar()
    {
        if (request()->getMethod() == 'POST') {

            $id = request('idBorrar');
            $trazabilidad = TrazabilidadConjuntos::where('id', $id)->first();
            $trazabilidad->delete();
            return json_encode('');
        }
    }

    public function tablaEtiqueta()
    {
        if (request()->getMethod() == 'POST') {
            $codigos = request('codigos');
            $codigos = json_decode($codigos);
            $opcion = request('ck');
            $resultado = [];
            if ($opcion == 'piezas') {
                foreach ($codigos as $value) {
                    $trazabilidad = TrazabilidadConjuntos::where('id', $value->id)->first();
                    $pieza = Pieza::where('CodPieza', $trazabilidad->CodPieza)->first();
                    $resultado[] = [
                        'pieza' => $pieza,
                        'trazabilidad' => $trazabilidad
                    ];
                }
            }
            if ($opcion == 'conjuntos') {
                foreach ($codigos as $value) {
                    $trazabilidad = TrazabilidadConjuntos::where('id', $value->id)->first();
                    $pieza = Conjunto::where('CodPieza', $trazabilidad->CodPieza)->first();
                    $resultado[] = [
                        'pieza' => $pieza,
                        'trazabilidad' => $trazabilidad
                    ];
                }
            }

            return json_encode($resultado);
        }
    }

    public function PDF()
    {
        if (request()->getMethod() == 'POST') {
            $id = request('id');
            $etChicas = request('etiquetasChicas');
            $etGrandes = request('etiquetasGrandes');
            $trazabilidad = TrazabilidadConjuntos::where('id', $id)->first();
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('vistaPDF', compact(['trazabilidad', 'etChicas', 'etGrandes']));
            return $pdf->stream();
        }
    }

    public function etChicasPDF()
    {
        $codigos = request('etiquetasChicas');
        $codigos = explode('/', $codigos);
        $tipo = request('tipoChicas');
        $resultado = $this->cargarResultado($codigos, $tipo);
        /* foreach ($codigos as $id) {
            $trazabilidad = TrazabilidadConjuntos::where('id', $id)->first();
            if ($trazabilidad !== null) {
                $pieza = Conjunto::where('CodPieza', $trazabilidad->CodPieza)->first();
                $resultado[] = [
                    'trazabilidad' => $trazabilidad,
                    'pieza' => $pieza,
                    'tamaño' => "chica",
                    'titulo' => "Etiquetas Chicas"
                ];
            }
        } */
        return $this->enviarVistaPDF($resultado);
    }

    public function etGrandesPDF()
    {
        $codigos = request('etiquetasGrandes');
        $codigos = explode('/', $codigos);
        $resultado = [];
        foreach ($codigos as $id) {
            $trazabilidad = TrazabilidadConjuntos::where('id', $id)->first();
            if ($trazabilidad !== null) {
                $pieza = Conjunto::where('CodPieza', $trazabilidad->CodPieza)->first();
                $resultado[] = [
                    'trazabilidad' => $trazabilidad,
                    'pieza' => $pieza,
                    'tamaño' => "grande",
                    'titulo' => "Etiquetas Grandes"
                ];
            }
        }
        return $this->enviarVistaPDF($resultado);
    }

    public function imprimirTodo()
    {
        $codigosG = request('etGrandes');
        $codigosC = request('etChicas');
        $codigosG = explode('/', $codigosG);
        $codigosC = explode('/', $codigosC);
        $resultado = [];
        foreach ($codigosG as $id) {
            $trazabilidad = TrazabilidadConjuntos::where('id', $id)->first();
            if ($trazabilidad !== null) {
                $pieza = Conjunto::where('CodPieza', $trazabilidad->CodPieza)->first();
                $resultado[] = [
                    'trazabilidad' => $trazabilidad,
                    'pieza' => $pieza,
                    'tamaño' => "grande",
                    'titulo' => "Etiquetas Grandes"
                ];
            }
        }

        foreach ($codigosC as $id) {
            $trazabilidad = TrazabilidadConjuntos::where('id', $id)->first();
            if ($trazabilidad !== null) {
                $pieza = Conjunto::where('CodPieza', $trazabilidad->CodPieza)->first();
                $resultado[] = [
                    'trazabilidad' => $trazabilidad,
                    'pieza' => $pieza,
                    'tamaño' => "chica",
                    'titulo' => "Etiquetas Chicas"
                ];
            }
        }
        return $this->enviarVistaPDF($resultado);
    }

    public function cargarResultado($codigos, $tipo)
    {
        $resultado = [];
        foreach ($codigos as $id) {
            $trazabilidad = TrazabilidadConjuntos::where('id', $id)->first();
            if ($trazabilidad !== null) {
                if ($tipo == 'conjunto') {
                    $pieza = Conjunto::where('CodPieza', $trazabilidad->CodPieza)->first();
                }
                if ($tipo == 'pieza') {
                    $pieza = Pieza::where('CodPieza', $trazabilidad->CodPieza)->first();
                }
                $resultado[] = [
                    'trazabilidad' => $trazabilidad,
                    'pieza' => $pieza,
                    'tamaño' => "grande",
                    'titulo' => "Etiquetas Grandes"
                ];
            }
        }
        return $resultado;
    }

    public function enviarVistaPDF($arrayDatos)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('vistaPDF', compact('arrayDatos'));
        return $pdf->stream();
    }
}
