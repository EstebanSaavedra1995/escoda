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
        $rta[] = $piezas;
        $rta[] = $conjuntos;
        return json_encode($rta);
    }

    public function store()
    {
        $codigo = request('codigo');
        $descripcion = request('descripcion');
        $medida = request('medida');
        $tipo = request('tipo');
        $croquis = request('croquis');
        $instruccion = request('instruccion');

        $conjunto = Conjunto::where('CodPieza', $codigo)->first();
        $pieza = Pieza::where('CodPieza', $codigo)->first();
        if ($conjunto != null || $pieza != null) {
            return json_encode('error');
        }
        if ($tipo == 'Conjunto') {
            $conjunto = new Conjunto();
            $conjunto->CodPieza = $codigo;
            $conjunto->NombrePieza = $descripcion;
            $conjunto->Medida = $medida;
            $conjunto->Croquis = $croquis;
            $conjunto->Instruccion = $instruccion;
            $conjunto->saveOrFail();
            return json_encode('ok');
        } else {
            $pieza = new Pieza();
            $pieza->CodPieza = $codigo;
            $pieza->NombrePieza = $descripcion;
            $pieza->Medida = $medida;
            $pieza->Croquis = $croquis;
            $pieza->Instruccion = $instruccion;
            $pieza->Stock = 0;
            $pieza->saveOrFail();
            return json_encode('ok');
        }
    }
    public function show()
    {
        $idCP = request('idCP');
        $tipo = request('tipo');
        if ($tipo == 'pieza') {
            $pieza = Pieza::where('CodPieza', $idCP)->first();
            $rta = ['tipo' => 'Pieza', 'dato' => $pieza];
            return json_encode($rta);
        } else {
            $conjunto = Conjunto::where('CodPieza', $idCP)->first();
            $rta = ['tipo' => 'Conjunto', 'dato' => $conjunto];
            return json_encode($rta);
        }
    }

    public function update()
    {
        $codigo = request('codigo2');
        $descripcion = request('descripcion2');
        $medida = request('medida2');
        $tipo = request('tipo2');
        $croquis = request('croquis2');
        $instruccion = request('instruccion2');
        if ($tipo == 'Pieza') {
            $pieza = Pieza::where('CodPieza', $codigo)->first();
            $pieza->NombrePieza = $descripcion;
            $pieza->Medida = $medida;
            $pieza->Croquis = $croquis;
            $pieza->Instruccion = $instruccion;
            $pieza->saveOrFail();
            return json_encode('ok');
        } else {
            $conjunto = Conjunto::where('CodPieza', $codigo)->first();
            $conjunto->NombrePieza = $descripcion;
            $conjunto->Medida = $medida;
            $conjunto->Croquis = $croquis;
            $conjunto->Instruccion = $instruccion;
            $conjunto->saveOrFail();
            return json_encode('ok');
        }
    }
}



/* id	
CodPieza	
NombrePieza	
Medida	
Croquis	
Instruccion	
Stock */

/* id	
CodPieza	
NombrePieza	
Medida	
Croquis	
Instruccion */