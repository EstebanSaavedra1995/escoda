<?php

namespace App\Http\Controllers\Admin\EgresosYEtiquetas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListarController extends Controller
{
    public function index(){
        return view('admin/egresosYEtiquetas/listar');
    }
}
