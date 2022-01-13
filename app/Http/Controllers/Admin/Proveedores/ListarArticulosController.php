<?php

namespace App\Http\Controllers\Admin\Proveedores;

use App\Http\Controllers\Controller;
use App\Models\ArticulosGenerales;
use App\Models\FacturaArticulos;
use App\Models\Goma;
use App\Models\Material;
use App\Models\ProveedorArticulos;
use App\Models\Proveedores;
use App\Models\ProveedorFactura;
use Illuminate\Http\Request;

class ListarArticulosController extends Controller
{
    public function index()
    {
        return view('admin.proveedores.listarArticulos');
    }

    public function listarArticulos()
    {
        $buscar = request('buscar');
        $buscarPor = request('buscarPor');
        /* $resultado[] = [
            'articulos' => null,
            'gomas' => null,
            'materiales' => null,
        ]; */

        if ($buscar == null) {
            $resultado[] = [
                'articulos' => ArticulosGenerales::all(),
                'gomas' => Goma::all(),
                'materiales' => Material::all(),
            ];
            
        } else {
            switch ($buscarPor) {
                case 'codigo':
                    $resultado[] = [
                        'articulos' => ArticulosGenerales::where('CodArticulo','like','%'. $buscar .'%')->get(),
                        'gomas' => Goma::where('CodigoGoma','like','%'. $buscar .'%')->get(),
                        'materiales' => Material::where('CodigoMaterial','like','%'. $buscar .'%')->get(),
                    ];
                    break;

                case 'descripcion':
                    $resultado[] = [
                        'articulos' => ArticulosGenerales::where('Descripcion','like','%'. $buscar .'%')->get(),
                        'gomas' => Goma::where('CodigoGoma','like','%'. $buscar .'%')->get(),
                        'materiales' => Material::where('CodigoMaterial','like','%'. $buscar .'%')->get(),
                    ];
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        
        return json_encode($resultado);
    }

    public function listarProveedores()
    {
        $resultado = null;
        $id = request('id');
        $proveedores = ProveedorArticulos::where('CodArticulo', $id)->get();
        if ($proveedores != null) {
            foreach ($proveedores as $prov) {
                $idProveedor = $prov->CodigoProv;
                $proveedor = Proveedores::where('CodigoProv', $idProveedor)->first();
                if ($proveedor != null) {
                    $provFac = ProveedorFactura::where('CodigoProv', $proveedor->CodigoProv)->first();
                    $factura = FacturaArticulos::where('CodProveedor', $proveedor->CodigoProv)
                    ->where('CodArticulo', $id)->first();
                    $resultado[] = [
                        'p' => $proveedor,
                        'pf' => $provFac,
                        'f' => $factura
                    ];
                }
            }
        }


        return json_encode($resultado);
    }
}
