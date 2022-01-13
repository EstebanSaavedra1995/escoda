<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TiemposOC;
use Illuminate\Http\Request;

class ListaTareasController extends Controller
{
    public function index() {
        $id = request('id');
        $piezas = TiemposOC::where('idDetalleOC', $id)
                        ->orderBy('Numero', 'ASC')->get();
        return view('admin.listaTareas',compact('piezas'));
    }
}
