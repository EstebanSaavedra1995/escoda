<?php

namespace App\Http\Controllers\Admin\Datos;

use App\Http\Controllers\Controller;
use App\Models\Conjunto;
use App\Models\Pieza;
use Illuminate\Http\Request;

class PiezaArticuloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $piezas = Pieza::all();
        $conjuntos = Conjunto::all();
        return view('admin.datos.piezas-articulos', compact(['piezas', 'conjuntos']));
    }
    public function buscarpiezas()
    {
        $buscador = request('buscador');
        $piezas = Pieza::where('CodPieza', 'LIKE', '%' . $buscador . '%')
            ->Orwhere('NombrePieza', 'LIKE', '%' . $buscador . '%')
            ->Orwhere('Medida', 'LIKE', '%' . $buscador . '%')->get();

        $conjuntos = Conjunto::where('CodPieza', 'LIKE', '%' . $buscador . '%')
        ->Orwhere('NombrePieza', 'LIKE', '%' . $buscador . '%')
        ->Orwhere('Medida', 'LIKE', '%' . $buscador . '%')->get();
        $rta = [];
        $rta [] = $piezas;
        $rta [] = $conjuntos;
        return json_encode($rta);
    }

    public function enviardatos () 
    {
        return json_encode('llegó');
    }
}
