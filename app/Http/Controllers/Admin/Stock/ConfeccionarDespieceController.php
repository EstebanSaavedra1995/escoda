<?php

namespace App\Http\Controllers\Admin\Stock;
use App\Models\Pieza;
use App\Http\Controllers\Controller;
use App\Models\ArticulosGenerales;
use App\Models\Conjunto;
use App\Models\Goma;
use App\Models\MaterialPieza;
use App\Models\PiezaDeConjunto;
use App\Models\Material;
use Illuminate\Http\Request;

class ConfeccionarDespieceController extends Controller
{
    public function index(){
        $piezas= Pieza::all();
        $gomas= Goma::all();
        $articulos= ArticulosGenerales::all();
        
        return view('admin\stock\confeccionarDespiece',compact(['piezas','gomas','articulos']));


    }

    public function piezas(){
        if (request()->getMethod() == 'POST') {
          $check = request('ck');
          
          if ($check == 'piezas'){ $piezas = Pieza::all(); }

          if ($check == 'conjuntos'){ $piezas = Conjunto::all(); }
 
          return json_encode($piezas);
        }
      }

      public function tabla(){
        if (request()->getMethod() == 'POST')
        {
            $codPieza = request('piezas');
            
            $check = request('ck');
          
            if ($check == 'piezas'){
                $materialPieza = MaterialPieza::where('codigoPieza', $codPieza)->first();  
                $material = Material::where('CodigoMaterial', $materialPieza->codigoMaterial)->first();
                $resultado = [
                    'material' => $material,
                  ];
                $materialPieza = $material;
            }
  
            if ($check == 'conjuntos'){ 
                $codPiezas = PiezaDeConjunto::where('codigoCjto', $codPieza)->get();
                $piezasConjunto = [];
                foreach ($codPiezas as  $value) {
                    $piezasConjunto[] = Pieza::where('CodPieza', $value->codigoPieza)->first();
                }
                $materialPieza = $piezasConjunto; 
            }

            return json_encode($materialPieza);
            
        }   
      }

      public function addGoma()
      {
        if (request()->getMethod() == 'POST') {
          $material= json_decode(request('material'));
          $coladaMaterial = ColadaMaterial::where('CodigoMaterial', $material->CodigoMaterial)->get();
          $resultado = ['coladaMaterial' => $coladaMaterial, 'material' => $material];
          return json_encode($resultado);
        }
      }
}
