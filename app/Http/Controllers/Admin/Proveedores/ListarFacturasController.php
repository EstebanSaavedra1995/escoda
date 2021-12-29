<?php

namespace App\Http\Controllers\Admin\Proveedores;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListarFacturasController extends Controller
{
    public function index()
    {
        return view('admin.proveedores.listarFacturas');
    }
}
