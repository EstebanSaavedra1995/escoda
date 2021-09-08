<?php

namespace App\Http\Controllers\Admin\Stock;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class ControlStockController extends Controller
{
    public function index(){
        
        return view('admin/stock/controlStock');
    }
}
