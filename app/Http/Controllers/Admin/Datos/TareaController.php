<?php

namespace App\Http\Controllers\Admin\Datos;

use App\Http\Controllers\Controller;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    //
    public function index()
    {
        $tareas = Tarea::all();
        return view('admin.datos.tareas', compact('tareas'));
    }
}
