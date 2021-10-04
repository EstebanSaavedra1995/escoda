<?php

namespace App\Http\Controllers\Admin\Proveedores;

use App\Http\Controllers\Controller;
use App\Models\ArticulosGenerales;
use App\Models\Goma;
use App\Models\Material;
use App\Models\ProveedorArticulos;
use App\Models\Proveedores;
use App\Models\ProveedorFactura;
use Illuminate\Http\Request;

class ListarProveedoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('admin.proveedores.listarProveedores');
    }

    public function listar(){
        $prov = Proveedores::all();
        $resultado = [];
        foreach ($prov as $value) {
            $provFac = ProveedorFactura::where('CodigoProv',$value->CodigoProv)->first();
            
            $resultado[] = [
                'p' => $value,
                'pf' => $provFac
            ]; 
        }
        return json_encode($resultado);
    }

    public function listarArticulos()
    {
        $id = request('id');
        $articulos = ProveedorArticulos::where('CodigoProv',$id)->get();
        $resultado = [];
        foreach ($articulos as $value) {
            $a = ArticulosGenerales::where('CodArticulo',$value->CodArticulo)->first();
            if ($a != null) {
                $articulosG[] = $a;
            }
            $g = Goma::where('CodigoGoma',$value->CodArticulo)->first();
            if ($g != null) {
                $gomas[] = $g;
            }
            $m = Material::where('CodigoMaterial',$value->CodArticulo)->first();
            if ($m != null) {
                $materiales[] = $m;
            }
            
        }
        $resultado[]= [
            'articulos' => $articulosG,
            'gomas' => $gomas,
            'materiales' => $materiales,
        ];
        return json_encode($resultado);
    }
}
