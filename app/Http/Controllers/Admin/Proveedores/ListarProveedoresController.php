<?php

namespace App\Http\Controllers\Admin\Proveedores;

use App\Http\Controllers\Controller;
use App\Models\ArticulosGenerales;
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
        /* $codArticulos = ProveedorArticulos::where('CodigoProv',$id)->get();
        $articulos=[];
        foreach ($codArticulos as $value) {
            $articulos[] = ArticulosGenerales::where('CodArticulo',$value->CodArticulo)->first();
        } */
        return json_encode($id);
    }
}
