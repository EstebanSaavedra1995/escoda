<?php

namespace App\Http\Controllers\Admin\EgresosYEtiquetas;

use App\Http\Controllers\Controller;
use App\Models\TrazabilidadConjuntos;
use App\Models\Conjunto;
use App\Models\Pieza;
use Illuminate\Http\Request;

class ListarController extends Controller
{
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
                    $fechaDesde = date_format($fechaDesde, "ymd");
                    $fechaHasta = request('fechaHasta');
                    $fechaHasta = date_create($fechaHasta);
                    $fechaHasta = date_format($fechaHasta, "ymd");
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

            return json_encode($trazabilidad);
        }
    }
}
