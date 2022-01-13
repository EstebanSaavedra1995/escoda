<?php

namespace App\Http\Controllers\Admin\Proveedores;

use App\Http\Controllers\Controller;
use App\Models\Proveedores;
use Illuminate\Http\Request;

class ListarFacturasController extends Controller
{
    public function index()
    {
        $proveedores = Proveedores::all();
        return view('admin.proveedores.listarFacturas',compact('proveedores'));
    }
}
