<?php

namespace App\Http\Controllers\Admin\Ordenes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Construccion;
use App\Models\Pieza;
use App\Models\MaterialPieza;


class ConstruccionController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }
  public function index(){
      $piezas = Pieza::all();
      $construccion = Construccion::orderBy('NroOC', 'desc')->first();
      $nroOC = $construccion->NroOC;
      $largo = strlen($nroOC);
      $nuevaOC = sprintf("%'0{$largo}d\n", intval($nroOC) + 1);
      return view('admin.ordenes.construccion', compact(['nuevaOC', 'piezas']));
  }

  public function piezas(){
    if (request()->getMethod() == 'POST') {
        $codPieza = request('piezas');
        $materialPieza = MaterialPieza::where('codigoPieza', $codPieza)->firstOrFail();
        
        return json_encode($materialPieza);
    }
  }

  /*  public function horasAsincronas()
  {

    $date = Carbon::now();
    $today = $date->format('Y-m-d');
    if (request()->getMethod() == 'POST') {
      $fecha = request('fecha');
      if ($fecha == $today) {
        return  response()->json($this->filtrarHorasHoy());
      } else {
        return  response()->json($this->cargarHoras());
      }
    }
  } */
}
