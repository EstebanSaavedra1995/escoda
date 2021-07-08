<?php

namespace App\Http\Controllers\Admin\Ordenes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ColadaMaterial;
use App\Models\Construccion;
use App\Models\Material;
use App\Models\Pieza;
use App\Models\MaterialPieza;
use App\Models\PiezaTarea;

class ConstruccionController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {
    $piezas = Pieza::all();
    $materiales = Material::all();
    $construccion = Construccion::orderBy('NroOC', 'desc')->first();
    $nroOC = $construccion->NroOC;
    $largo = strlen($nroOC);
    $nuevaOC = sprintf("%'0{$largo}d\n", intval($nroOC) + 1);
    return view('admin.ordenes.construccion', compact(['nuevaOC', 'piezas','materiales']));
  }

  public function piezas()
  {
    if (request()->getMethod() == 'POST') {
      $codPieza = request('piezas');
      $materialPieza = MaterialPieza::where('codigoPieza', $codPieza)->first();
      if ($materialPieza != null) {
        $material = Material::where('CodigoMaterial', $materialPieza->codigoMaterial)->first();
        $coladaMaterial = ColadaMaterial::where('CodigoMaterial', $materialPieza->codigoMaterial)->get();
        $piezaTarea = PiezaTarea::where('codigoPieza', $codPieza)->get();
        $resultado = [
          'materialPieza' => $materialPieza, 'material' => $material,
          'coladaMaterial' => $coladaMaterial, 'piezaTarea' => $piezaTarea
        ];
        return json_encode($resultado);
      } else {
        $resultado = [];
        return json_encode($resultado);
      }
    }
    /* return json_encode(request('piezas')); */
  }
}
