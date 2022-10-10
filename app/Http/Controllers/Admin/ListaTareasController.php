<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PausasOC;
use App\Models\TiemposOC;
use Illuminate\Http\Request;

class ListaTareasController extends Controller
{
    public function index()
    {
        $id = request('id');
        $piezas = TiemposOC::where('idDetalleOC', $id)
            ->join('users', 'users.id', '=', 'tiemposoc.idUsuario')
            //->join('personal', 'personal.NroLegajo', '=', 'users.NroLegajo')
            ->orderBy('Numero', 'ASC')->get();
        return view('admin.listaTareas', compact('piezas'));
        //echo $piezas;
    }

    public function pausas()
    {
        $id = request('id');
        $pausas = PausasOC::where('idDetalleOC', $id)
            ->join('users', 'users.id', '=', 'pausasoc.idUsuario')
            ->orderBy('pausasoc.id', 'DESC')->get();
        return view('admin.listaPausas', compact('pausas'));
        //echo $piezas;
    }
}
