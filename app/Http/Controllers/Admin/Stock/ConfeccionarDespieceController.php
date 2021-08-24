<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Models\Pieza;
use App\Http\Controllers\Controller;
use App\Models\ArticulosGenerales;
use App\Models\Conjunto;
use App\Models\conjuntoArticulos;
use App\Models\ConjuntoArticulos as ModelsConjuntoArticulos;
use App\Models\ConjuntoGomas;
use App\Models\Goma;
use App\Models\MaterialPieza;
use App\Models\PiezaDeConjunto;
use App\Models\Material;
use Illuminate\Http\Request;

class ConfeccionarDespieceController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
  
  public function index()
  {
    $piezas = Pieza::all();
    $gomas = Goma::all();
    $articulos = ArticulosGenerales::all();
    $materiales = Material::all();

    return view('admin\stock\confeccionarDespiece', compact(['piezas', 'gomas', 'articulos', 'materiales']));
  }

  public function piezas()
  {
    if (request()->getMethod() == 'POST') {
      $check = request('ck');

      if ($check == 'piezas') {
        $piezas = Pieza::all();
        $materialPieza = MaterialPieza::all();
        $resultado = [
          'piezas' => $piezas,
          'materialPieza' => $materialPieza
        ];
      }

      if ($check == 'conjuntos') {
        $conjunto = Conjunto::all();
        $piezaConjunto = PiezaDeConjunto::all();
        $resultado = [
          'conjunto' => $conjunto,
          'piezaConjunto' => $piezaConjunto
        ];
      }

      return json_encode($resultado);
    }
  }

  public function tabla()
  {
    if (request()->getMethod() == 'POST') {
      $codPieza = request('piezas');

      $check = request('ck');

      if ($check == 'piezas') {
        $materialPieza = MaterialPieza::where('codigoPieza', $codPieza)->first();
        $material = Material::where('CodigoMaterial', $materialPieza->codigoMaterial)->first();
        $resultado = [
          'material' => $material,
          'cantidad' => $materialPieza->longitudCorte
        ];
      }

      if ($check == 'conjuntos') {
        $codPiezas = PiezaDeConjunto::where('codigoCjto', $codPieza)->get();
        $codArticulos = ConjuntoArticulos::where('CodPieza', $codPieza)->get();
        $codGomas = ConjuntoGomas::where('CodPieza', $codPieza)->get();
        $resultado = [];
        //obtengo piezas
        foreach ($codPiezas as  $value) {
          $resultado[] = [
            'tipo' => 'pieza',
            'pieza' => Pieza::where('CodPieza', $value->codigoPieza)->first(),
            'cantidad' => $value->Cantidad
          ];
        }
        //obtengo articulos
        foreach ($codArticulos as  $value) {
          $resultado[] = [
            'tipo' => 'articulo',
            'articulo' => ArticulosGenerales::where('CodArticulo', $value->CodArticulo)->first(),
            'cantidad' => $value->Cantidad
          ];
        }
        //obtengo gomas
        foreach ($codGomas as  $value) {
          $resultado[] = [
            'tipo' => 'goma',
            'goma' => Goma::where('CodigoGoma', $value->CodigoGoma)->first(),
            'cantidad' => $value->Cantidad
          ];
        }
      }

      return json_encode($resultado);
    }
  }

  function predeterminar()
  {
    if (request()->getMethod() == 'POST') {
      $tabla = request('valores');
      $check = request('ck');
      $conjunto = request('conjunto');
      $tabla = json_decode($tabla);

      if ($check == 'piezas') {
        $material = MaterialPieza::where('codigoPieza', $conjunto)->delete();
        $value= $tabla[0];
        $material = new MaterialPieza();
        $material->codigoPieza = $conjunto;
        $material->codigoMaterial = $value->id;
        $material->longitudCorte = $value->cantidad;
        $material->save(); 
      }

      if ($check == 'conjuntos') {
        //$pieza = new PiezaDeConjunto();
        $articulo = ConjuntoArticulos::where('CodPieza', $conjunto)->get();
        $goma = ConjuntoGomas::where('CodPieza', $conjunto)->get();
        $pieza = PiezaDeConjunto::where('codigoCjto', $conjunto)->get();

        foreach ($pieza as $a) {
          $a->delete();
        }
        foreach ($articulo as $a) {
          $a->delete();
        }
        foreach ($goma as $a) {
          $a->delete();
        }

        foreach ($tabla as $value) {

          switch ($value->tipo) {
            case 'pieza':
              $pieza = new PiezaDeConjunto();
              $pieza->codigoCjto = $conjunto;
              $pieza->codigoPieza = $value->id;
              $pieza->Cantidad = $value->cantidad;
              $pieza->save();
              break;

            case 'articulo':
              $articulo = new conjuntoArticulos();
              $articulo->CodPieza = $conjunto;
              $articulo->CodArticulo = $value->id;
              $articulo->Cantidad = $value->cantidad;
              $articulo->save();
              break;

            case 'goma':
              $goma = new ConjuntoGomas();
              $goma->CodPieza = $conjunto;
              $goma->CodigoGoma = $value->id;
              $goma->Cantidad = $value->cantidad;
              $goma->save();
              break;
          }
        }
      }
      return json_encode("");
    }
  }
}
