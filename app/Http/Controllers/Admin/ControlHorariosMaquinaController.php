<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ControlHorariosMaquinaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('admin\controlHorariosMaquina');
    }
    /* public function indexControl(){
        return view('admin\ControlTiempos\controlTiempos');
    }
    public function indexTiempos(){
        return view('admin\ControlTiempos\tiempos');
    } */
}
