<?php

namespace App\Http\Controllers\Admin\Ordenes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ColadaMaterial;
use App\Models\Construccion;
use App\Models\Maquina;
use App\Models\Material;
use App\Models\Pieza;
use App\Models\MaterialPieza;
use App\Models\Personal;
use App\Models\PiezaTarea;
use App\Models\Tarea;

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
    $tareas= Tarea::all();
    $maquinas= Maquina::all();
    $supervisores= Personal::where('Cargo', 'Supervisor de Área')
                          ->where('Estado','A')->get();



    $operarios= Personal::Where('Estado','A')
    ->orwhere([
      ['Cargo','Operario Ayudante'],
      ['Cargo','Operario c/ Especializacion'],
      ['Cargo','Supervisor de Área']
      ])->get();
    $nroOC = $construccion->NroOC;
    $largo = strlen($nroOC);
    $nuevaOC = sprintf("%'0{$largo}d\n", intval($nroOC) + 1);
    return view('admin.ordenes.construccion', compact(['nuevaOC', 'piezas','materiales','tareas','maquinas','supervisores','operarios']));
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
  }

  public function material()
  {
    if (request()->getMethod() == 'POST') {
      $codigoMaterial= request('codigoMaterial');
      $material= Material::where('CodigoMaterial', $codigoMaterial)->first();
      $coladaMaterial = ColadaMaterial::where('CodigoMaterial', $codigoMaterial)->get();
      $resultado = ['coladaMaterial' => $coladaMaterial, 'material' => $material];
      return json_encode($resultado);
    }
  }
  public function buscarMaterial()
  {
    if (request()->getMethod() == 'POST') {
      $buscador= request('buscarmaterial');
      $materiales = Material::where('CodigoMaterial','LIKE','%'.$buscador.'%')->get();
      return json_encode($materiales);
    }
  }
}
