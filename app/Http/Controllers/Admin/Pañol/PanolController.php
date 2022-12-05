<?php

namespace App\Http\Controllers\Admin\Pañol;

use App\Http\Controllers\Controller;
use App\Models\Herramientas;
use App\Models\Maquina;
use App\Models\Panol;
use App\Models\User;
use Illuminate\Http\Request;

class PanolController extends Controller
{


    public function index()
    {
        $herramientas = Herramientas::all();
        $users = User::all();
        $panol = Panol::all();
        return view('admin.pañol.index',compact(['herramientas','users','panol']));
    }

    public function prestar($idHerramienta){
        $herramienta = Herramientas::find($idHerramienta);
        $users = User::all();
        $maquina = Maquina::all();
        
        return view('admin.pañol.prestar',compact(['herramienta','users','maquina']));
    }

    public function save(Request $request){
        $pañol = new Panol();
        $pañol->idHerramienta = $request->idH;
        $pañol->idOperario = $request->operario;
        $pañol->idMaquina = $request->maquina;
        $pañol->fechaSalida = date("y-m-d H:i:s");
        $pañol->save();

        $herramienta = Herramientas::find($request->idH);
        $herramienta->stock --;

        if ($herramienta->stock <= 0 && $herramienta->tipo == "maquina") {
            $herramienta->estado= "No Disponible";
        }

        $herramienta->save();
        return redirect()->route('panol');
    }
}
