<?php

namespace App\Http\Controllers\Admin\Proveedores;

use App\Http\Controllers\Controller;
use App\Models\ArticulosGenerales;
use App\Models\FacturaArticulos;
use App\Models\Goma;
use App\Models\Iva;
use App\Models\Material;
use App\Models\Proveedores;
use App\Models\ProveedorFactura;
use Illuminate\Http\Request;

use function GuzzleHttp\json_decode;

class ListarFacturasController extends Controller
{
    public function index()
    {
        $proveedores = Proveedores::all();
        $iva = Iva::all();
        return view('admin.proveedores.listarFacturas', compact(['proveedores', 'iva']));
    }

    public function listarFacturas()
    {
        $fechaDesde = request('desde');
        $fechaDesde = date_create($fechaDesde);
        $fechaDesde = date_format($fechaDesde, "ymd");

        $fechaHasta = request('hasta');
        $fechaHasta = date_create($fechaHasta);
        $fechaHasta = date_format($fechaHasta, "ymd");

        $codProveedor = request('proveedor');
        $resultado = [];
        $provFac = '';
        $facArt = '';
        if ($fechaDesde != null && $fechaHasta != null) {
            $provFac = ProveedorFactura::where('CodigoProv', $codProveedor)
                ->where('Fecha', '>=', $fechaDesde)
                ->where('Fecha', '<=', $fechaHasta)->get();
        } else {
            $provFac = ProveedorFactura::where('CodigoProv', $codProveedor)->get();
        }

        $valor = 0;
        foreach ($provFac as $value) {
            $facArt = FacturaArticulos::where('NroFactura', $value->NroFactura)
                ->where('CodProveedor', $codProveedor)->get();
            foreach ($facArt as $fac) {
                $valor = floatval($valor) + (floatval($fac->PrecioUnitario) * floatval($fac->Cantidad));
            }
            $resultado[] = [
                'proveedorFactura' => $value,
                'valor' => $valor
            ];
            $valor = 0;
        }

        return json_encode($resultado);
    }

    public function listarArticulos()
    {
        $codFactura = request('codFactura');
        $codProveedor = request('codProveedor');
        $facArt = FacturaArticulos::where('NroFactura', $codFactura)
            ->where('CodProveedor', $codProveedor)->get();
        return json_encode($facArt);
    }

    public function llenarModal()
    {
        $codFactura = request('codFactura');
        $codProveedor = request('codProveedor');
        $facArt = FacturaArticulos::where('NroFactura', $codFactura)
            ->where('CodProveedor', $codProveedor)->get();
        $provFac = ProveedorFactura::where('CodigoProv', $codProveedor)
            ->where('NroFactura', $codFactura)->first();

        $proveedor = Proveedores::where('CodigoProv', $codProveedor)->first();
        $resultado = [
            'proveedorFactura' => $provFac,
            'facturaArticulos' => $facArt,
            'proveedor' => $proveedor
        ];
        return json_encode($resultado);
    }

    public function guardarFactura()
    {
        $idPF = request('pFacId');
        $proveedoresMod = request('proveedoresMod');
        $tipo = request('tipo');
        $iva = request('iva');
        $fechaMod = request('fechaMod');
        $obsMod = request('obsMod');
        $bonif = request('bonif');
        $calValor = request('calValor');
        $calFin = request('calFin');
        $calEntrega = request('calEntrega');
        $calCalidad = request('calCalidad');
        $provFac = ProveedorFactura::find($idPF);
        $nroFac = $provFac->NroFactura;
        $provFac->Letra = $tipo;
        $provFac->CodigoProv = $proveedoresMod;
        $provFac->Fecha = $fechaMod;
        $provFac->Observaciones = $obsMod;
        $provFac->CalifValor = $calValor;
        $provFac->CalifFinanzacion = $calFin;
        $provFac->CalifEntrega = $calEntrega;
        $provFac->CalifCalidad = $calCalidad;
        $provFac->AlicuotaIVA = $iva;
        $provFac->Bonificacion = $bonif;
        $provFac->save();
        $a = request('valores');
        $facArt = FacturaArticulos::where('NroFactura', $nroFac)
            ->where('CodProveedor', $proveedoresMod)->get();
        $valores = json_decode($a);
        foreach ($facArt as $x) {
            $x->delete();
        }

        foreach ($valores as $x) {
            $fac = new FacturaArticulos();
            $fac->NroFactura = $nroFac;
            $fac->Letra = $tipo;
            $fac->CodProveedor = $proveedoresMod;
            $fac->Cantidad = $x->cantidad;
            if ($x->precio != null) {
                $fac->PrecioUnitario = $x->precio;
            }else{
                $fac->PrecioUnitario = '0';
            }
            $fac->Observaciones = $x->observaciones;
            $fac->CodArticulo = $x->cod;
            $fac->Descripcion = $x->descripcion;
            $fac->save();   
        }



        return json_encode($facArt);
    }

    public function buscarProducto()
    {
        $cod = request('cod');
        $resultado ='';

        $a = ArticulosGenerales::where('CodArticulo', $cod)->first();
        if ($a != null) {
            $resultado = $a;
        }

        $g = Goma::where('CodigoGoma', $cod)->first();
        if ($g != null) {
            $resultado= $g;
        }

        $m = Material::where('CodigoMaterial', $cod)->first();
        if ($m != null) {
            $resultado = $m;
        }

        return json_encode($resultado);
    }
}
