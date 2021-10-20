<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Pieza;
use Illuminate\Http\Request;

class ControlStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

        return view('admin/stock/controlStock');
    }

    public function egreso($id, $tipo)
    {
        $pieza = Pieza::find($id);
        return view('admin/stock/controlStockEgreso', compact('pieza', 'tipo'));
    }
}
