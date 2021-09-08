<?php

namespace App\Http\Controllers\Admin\Maquinas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaquinaController extends Controller
{
    public function __construct()
  {
    $this->middleware('auth');
  }
  
    public function asignar(){
        return 'asdasd';
    }
}
