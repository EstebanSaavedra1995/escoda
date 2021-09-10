<?php

namespace App\Http\Controllers\Admin\Ordenes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ColadaMaterial;
use App\Models\Construccion;
use App\Models\DetalleOC;
use App\Models\Maquina;
use App\Models\Material;
use App\Models\Pieza;
use App\Models\MaterialPieza;
use App\Models\Personal;
use App\Models\PiezaOCStock;
use App\Models\PiezaTarea;
use App\Models\Tarea;
use App\Models\TotalStockMateriales;
use App\Models\TotalStockPiezas;

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
    $tareas = Tarea::all();
    $maquinas = Maquina::all();
    $supervisores = Personal::where('Cargo', 'Supervisor de Área')
      ->where('Estado', 'A')->get();



    $operarios = Personal::Where('Estado', 'A')
      ->orwhere([
        ['Cargo', 'Operario Ayudante'],
        ['Cargo', 'Operario c/ Especializacion'],
        ['Cargo', 'Supervisor de Área']
      ])->get();
    $nroOC = $construccion->NroOC + 1;
    $largo = strlen($nroOC);
    $nuevaOC = str_repeat('0', 8 - $largo);
    $nuevaOC .= $nroOC;
    return view('admin.ordenes.construccion', compact(['nuevaOC', 'piezas', 'materiales', 'tareas', 'maquinas', 'supervisores', 'operarios']));
  }

  public function piezas()
  {
    if (request()->getMethod() == 'POST') {
      $codPieza = request('piezas');
      $materialPieza = MaterialPieza::where('codigoPieza', $codPieza)->first();
      if ($materialPieza != null) {
        $material = Material::where('CodigoMaterial', $materialPieza->codigoMaterial)->first();
        $coladaMaterial = ColadaMaterial::where('CodigoMaterial', $materialPieza->codigoMaterial)
          ->where('Stock', '>', 0)->get();
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
      $codigoMaterial = request('codigoMaterial');
      $material = Material::where('CodigoMaterial', $codigoMaterial)->first();
      $coladaMaterial = ColadaMaterial::where('CodigoMaterial', $codigoMaterial)->get();
      $resultado = ['coladaMaterial' => $coladaMaterial, 'material' => $material];
      return json_encode($resultado);
    }
  }
  public function buscarMaterial()
  {
    if (request()->getMethod() == 'POST') {
      $buscador = request('buscarmaterial');
      $materiales = Material::where('CodigoMaterial', 'LIKE', '%' . $buscador . '%')->get();
      return json_encode($materiales);
    }
  }
  public function modificarTarea()
  {
    if (request()->getMethod() == 'POST') {

      $tareas = Tarea::all();
      $maquinas = Maquina::all();

      $supervisores = Personal::where('Cargo', 'Supervisor de ├ürea') //MODIFICAR CUANDO SE CAMBIE DE BASE
        ->where('Estado', 'A')->get();

      $operarios = Personal::Where('Estado', 'A')
        ->orwhere([
          ['Cargo', 'Operario Ayudante'],
          ['Cargo', 'Operario c/ Especializacion'],
          ['Cargo', 'Supervisor de Área']
        ])->get();

      $tarea = [
        'tareas' => $tareas, 'maquinas' => $maquinas,
        'supervisores' => $supervisores, 'operarios' => $operarios
      ];
      return json_encode($tarea);
    }
  }



  public function agregarconstruccion()
  {


    $tareas = request('arreglo');
    $tareas = json_decode($tareas);
    $pieza = request('piezas');
    $cantidadRealizar = request('cantidad-realizar');
    $idMaterial = request('idmaterial');
    $colada = request('nameradio');
    $cantidadMaterial = request('cantidad-necesaria');
    $longitudCorte = request('longcorte');
    $fecha = date('y-m-d');
    $fecha = str_replace('-', '', $fecha);
    $nroOC = request('numerooc');

    $ordenConstruccion = new Construccion();
    $ordenConstruccion->NroOC = strval($nroOC);
    $ordenConstruccion->Fecha = $fecha;
    $ordenConstruccion->CodigoPieza = $pieza;
    $ordenConstruccion->Cantidad = intval($cantidadRealizar);
    $ordenConstruccion->CodigoMaterial = $idMaterial;
    $ordenConstruccion->LongitudCorte = doubleval($longitudCorte);
    $ordenConstruccion->Colada = $colada;
    $ordenConstruccion->Estado = 'A';
    $ordenConstruccion->saveOrFail();

    foreach ($tareas as $key => $tarea) {
      $detalleOC = new DetalleOC();
      $detalleOC->NroOC = strval($nroOC);
      $detalleOC->Tarea = $tarea[0];
      $detalleOC->Maquina = $tarea[1];
      $detalleOC->Operario = $tarea[2];
      $detalleOC->Supervisor = $tarea[3];
      $detalleOC->Horas = $tarea[4];
      $detalleOC->Renglon = $key + 1;
      $detalleOC->Estado = "";
      $detalleOC->saveOrFail();
    }

    $piezaOCStock = new PiezaOCStock();
    $piezaOCStock->NroOC = strval($nroOC);
    $piezaOCStock->Stock = intval($cantidadRealizar);
    $piezaOCStock->saveOrFail();

    $coladaMaterial = ColadaMaterial::where('CodigoMaterial', $idMaterial)
      ->where('Colada', $colada)->first();
    $coladaMaterial->Stock = $coladaMaterial->Stock - $cantidadMaterial;
    $coladaMaterial->saveOrFail();

    $materiales = Material::where('CodigoMaterial', $idMaterial)->first();
    $materiales->Stock = $materiales->Stock - $cantidadMaterial;
    $materiales->saveOrFail();

    $totalStockPiezas = TotalStockPiezas::where('CodigoPieza', $pieza)->first();
    $totalStockPiezas->Stock = $totalStockPiezas->Stock + $ordenConstruccion->Cantidad;
    $totalStockPiezas->saveOrFail();

    $totalStockMateriales = TotalStockMateriales::where('CodigoMaterial', $idMaterial)->first();
    $totalStockMateriales->Stock = $totalStockMateriales->Stock - $cantidadMaterial;
    $totalStockMateriales->saveOrFail();

    return json_encode('ok');
  }
}
