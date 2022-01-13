<?php

namespace App\Http\Controllers\Admin\Proveedores;

use App\Http\Controllers\Controller;
use App\Models\FacturaArticulos;
use App\Models\Iva;
use App\Models\Proveedores;
use App\Models\ProveedorFactura;
use Illuminate\Http\Request;

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
}
