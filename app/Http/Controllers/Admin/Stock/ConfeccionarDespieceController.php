<?php

namespace App\Http\Controllers\Admin\Stock;
use App\Models\Pieza;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfeccionarDespieceController extends Controller
{
    public function index(){
        $piezas= Pieza::all();
        $a=0;
     
        return view('admin\stock\confeccionarDespiece',compact(['a','piezas']));
        
    }
}
