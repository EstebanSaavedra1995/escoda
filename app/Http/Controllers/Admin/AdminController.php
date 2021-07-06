<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pieza;
use App\Models\Construccion;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $piezas = Pieza::all();
        $construccion = Construccion::orderBy('NroOC', 'desc')->first();
        $nroOC = $construccion->NroOC;
        $largo = strlen($nroOC);
        $nuevaOC = sprintf("%'0{$largo}d\n", intval($nroOC) + 1);
        return view('admin.construccion', compact(['nuevaOC', 'piezas']));
    }

    public function piezas(){
        return 'Piezas';
    }
}
