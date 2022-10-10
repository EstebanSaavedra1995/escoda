<?php

namespace App\Http\Controllers\Admin\Pañol;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PanolController extends Controller
{
    public function index()
    {
        return view('admin.pañol.index');
    }
}
