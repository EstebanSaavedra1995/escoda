<?php

namespace App\Http\Controllers\Admin\EgresosYEtiquetas;

use App\Http\Controllers\Controller;
use App\Models\Pieza;
use App\Models\MaterialPieza;
use App\Models\Conjunto;
use App\Models\PiezaDeConjunto;
use App\Models\TrazabilidadConjuntos;
use Illuminate\Http\Request;

class RegistrarEgresosController extends Controller
{
  public function index()
  {
    return view('admin/egresosYEtiquetas/registrarEgresos');
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
//tabla del modal
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
          $nroEgreso = str_pad($nroEgreso, 8, "0", STR_PAD_LEFT);
          $trazabilidad = TrazabilidadConjuntos::where('NroEgreso', $nroEgreso)->get();
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

  public function guardar()
  {
    if (request()->getMethod() == 'POST') {
      $fechaEgreso = request('fechaEgreso');
      $fechaEgreso = date_create($fechaEgreso);
      $fechaEgreso = date_format($fechaEgreso, "ymd");
      $condicion = request('condicion');
      if ($condicion == 'CONDICION I') {
        $condicion = 'I';
      }
      if ($condicion == 'CONDICION II') {
        $condicion = 'II';
      }
      $tipo = request('tipoEgreso');
      $nroEgreso = request('nroEgreso');
      $fechaIntervencion = request('fechaIntervencion');
      $fechaIntervencion = date_create($fechaIntervencion);
      $fechaIntervencion = date_format($fechaIntervencion, "ymd");
      $pozo = request('pozo');
      $orden = request('ordenTarea');
      $pieza = request('piezas');
      $numero = TrazabilidadConjuntos::where('CodPieza', $pieza)
        ->orderBy('Numero', 'DESC')->first()->Numero;
      $cantidad = request('cantidad');

      for ($i = 0; $i < $cantidad; $i++) {
        $trazabilidad = new TrazabilidadConjuntos();
        $trazabilidad->CodPieza = $pieza;
        $numero++;
        $trazabilidad->Numero = $numero;
        $trazabilidad->Fecha = $fechaEgreso;
        $trazabilidad->Condicion = $condicion;
        $trazabilidad->TipoEgreso = $tipo;
        $trazabilidad->NroEgreso = $nroEgreso;
        $trazabilidad->FechaIntervencion = $fechaIntervencion;
        $trazabilidad->Pozo = $pozo;
        $trazabilidad->NroOR = $orden;
        $trazabilidad->IE = 'E';
        $trazabilidad->save();
      }
      return json_encode($numero);
    }
  }
}
