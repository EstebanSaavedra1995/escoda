<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin\registrarEgresos');
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

    public function tabla(){
      if (request()->getMethod() == 'POST') {
        //$check = request('ckMod');
        $trazabilidad = TrazabilidadConjuntos::all();
        return json_encode($trazabilidad);
      }
    }

    
}
