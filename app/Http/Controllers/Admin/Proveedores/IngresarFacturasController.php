<?php

namespace App\Http\Controllers\Admin\Proveedores;

use App\Http\Controllers\Controller;
use App\Models\ArticulosGenerales;
use App\Models\ColadaMaterial;
use App\Models\FacturaArticulos;
use App\Models\Goma;
use App\Models\Iva;
use App\Models\Material;
use App\Models\ProveedorArticulos;
use App\Models\Proveedores;
use App\Models\ProveedorFactura;
use App\Models\TotalStockMateriales;
use Illuminate\Http\Request;

class IngresarFacturasController extends Controller
{

    public function index()
    {
        $proveedores = Proveedores::all();
        $iva = Iva::all();
        return view('admin.proveedores.IngresarFactura', compact(['proveedores', 'iva']));
    }

    public function getProveedor()
    {
        $cod = request('proveedores');
        $proveedor = Proveedores::where('CodigoProv', $cod)->first();

        return json_encode($proveedor);
    }

    public function getArticulos()
    {
        $cod = request('proveedores');
        $articulos = ProveedorArticulos::where('CodigoProv', $cod)->get();
        $resultado = [];
        $articulosG = null;
        $gomas = null;
        $materiales = null;
        foreach ($articulos as $value) {
            $a = ArticulosGenerales::where('CodArticulo', $value->CodArticulo)->first();
            if ($a != null) {
                $articulosG[] = $a;
            }

            $g = Goma::where('CodigoGoma', $value->CodArticulo)->first();
            if ($g != null) {
                $gomas[] = $g;
            }

            $m = Material::where('CodigoMaterial', $value->CodArticulo)->first();
            if ($m != null) {
                $materiales[] = $m;
            }
        }
        $resultado[] = [
            'articulos' => $articulosG,
            'gomas' => $gomas,
            'materiales' => $materiales,
        ];
        return json_encode($resultado);
    }

    public function getArticulo()
    {
        $cod = request('selectArt');
        $resultado = null;

        $a = ArticulosGenerales::where('CodArticulo', $cod)->first();
        if ($a != null) {
            $resultado = $a;
        }

        $g = Goma::where('CodigoGoma', $cod)->first();
        if ($g != null) {
            $resultado = $g;
        }

        $m = Material::where('CodigoMaterial', $cod)->first();
        if ($m != null) {
            $resultado = $m;
        }

        return json_encode($resultado);
    }

    public function saveFactura()
    {
        $codArticulos = explode(",", request('codigos'));
        $codProv = request('proveedores');
        $tipo = request('tipo');
        $fecha = date_create(request('fechaMod'));
        $fecha = date_format($fecha, 'ymd');
        $iva = request('iva');
        $obs = request('obsMod');
        $calValor = request('calValor');
        $calFin = request('calFin');
        $calEntrega = request('calEntrega');
        $calCalidad = request('calCalidad');
        $bonif = request('bonif');

        $ultimaFact = ProveedorFactura::OrderBy('NroFactura', 'DESC')->first();

        $aux = explode("-", $ultimaFact->NroFactura);

        $nroFact = $aux[1] + 1;
        $nroFact = $aux[0] . '-' . $nroFact;

        $factura = new ProveedorFactura();
        $factura->NroFactura = $nroFact;
        $factura->Letra = $tipo;
        $factura->CodigoProv = $codProv;
        $factura->Fecha = $fecha;
        $factura->Observaciones = $obs;
        $factura->CalifValor = $calValor;
        $factura->CalifFinanzacion = $calFin;
        $factura->CalifEntrega = $calEntrega;
        $factura->CalifCalidad = $calCalidad;
        $factura->AlicuotaIVA = $iva;
        $factura->Bonificacion = $bonif;
        $factura->saveOrFail();
        $a='';
        for ($i = 0; $i < sizeof($codArticulos); $i++) {
            $factArt = new FacturaArticulos();
            $factArt->NroFactura = $nroFact;
            $factArt->Letra = $tipo;
            $factArt->CodProveedor = $codProv;
            $factArt->Cantidad = request('can' . $codArticulos[$i]);
            $factArt->PrecioUnitario = request('precio' . $codArticulos[$i]);
            $factArt->Observaciones = request('obs' . $codArticulos[$i]);
            $factArt->CodArticulo = $codArticulos[$i];
            $factArt->Descripcion = request('desc' . $codArticulos[$i]);
            $factArt->saveOrFail();
            $a ='sin' . $codArticulos[$i];
            switch (request('sin' . $codArticulos[$i])) {
                case 'Materiales':
                    $colada = request('col' . $codArticulos[$i]);
                    
                    $coladaMat = ColadaMaterial::find($colada);
                    $coladaMat->Stock = $coladaMat->Stock + request('can' . $codArticulos[$i]);
                    $coladaMat->saveOrFail();
                    
                    $totalStock = TotalStockMateriales::where('CodigoMaterial',$codArticulos[$i])->first();
                    $totalStock->Stock = $totalStock->Stock + request('can' . $codArticulos[$i]);
                    $totalStock->saveOrFail();
                    
                    $material = Material::where('CodigoMaterial',$codArticulos[$i])->first();
                    $material->Stock = $material->Stock + request('can' . $codArticulos[$i]);
                    $material->saveOrFail();

                    break;

                case 'Articulos':
                    $articulo = ArticulosGenerales::where('CodArticulo',$codArticulos[$i])->first();
                    $articulo->Stock = $articulo->Stock + request('can' . $codArticulos[$i]);
                    $articulo->saveOrFail();
                    break;

                case 'Gomas':
                    $goma = Goma::where('CodigoGoma',$codArticulos[$i])->first();
                    $goma->Stock = $goma->Stock + request('can' . $codArticulos[$i]);
                    $goma->saveOrFail();
                    break;

                default:
                    # code...
                    break;
            }
        }
        return json_encode('ok');
        /* $colada = request('colCORIND-23'); 
        $coladaMat = ColadaMaterial::find($colada);
        $coladaMat->Stock =$coladaMat->Stock + request('canCORIND-23');
        $coladaMat->saveOrFail();
        echo json_encode($coladaMat->Stock);  */
    }
    
    
    public function getColada()
    {
        $cod = request('codigo');
        $coladas = ColadaMaterial::where('CodigoMaterial',$cod)->get();
        return json_encode($coladas);
    }
}

