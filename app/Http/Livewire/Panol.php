<?php

namespace App\Http\Livewire;

use App\Clases\HerramientaMaquina;
use App\Clases\HerramientaPersonal;
use App\Models\Herramientas;
use App\Models\Maquina;
use App\Models\Panol as ModelsPanol;
use App\Models\Personal;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;

use function GuzzleHttp\Promise\all;

class Panol extends Component
{
    public $herramientas;
    public $users;
    public $panol;
    public $operarios;
    public $tablaPanol;
    public $idHerramienta;
    public $idOperario;

    public function mount()
    {
       $this->herramientas = Herramientas::all();
       $this->users = User::all();
       $this->panol = ModelsPanol::where("devuelto","=","0")->get();
       $this->operarios = Personal::all();
       $this->idHerramienta = '';
       $this->idOperario = '';
       $this->tablaPanol = [];
       $this->armarTablaPanol();
    }

    public function render()
    {   
        
        return view('livewire.panol');
    }
    
    public function guardar()
    {
     $panol = new ModelsPanol();
     $panol->idHerramienta = $this->idHerramienta;
     $panol->idOperario = $this->idOperario;
     $panol->fechaSalida = date("y-m-d H:i:s");
     $panol->save();

    }

    public function armarTablaPanol(){
        foreach ($this->panol as $value) {
            $auxx = [
                'herramienta' => Herramientas::find($value->idHerramienta),
                'operario' => User::find($value->idOperario),
                'maquina' => Maquina::find($value->idMaquina),
                'panol' => $value,
            ];
            $this->tablaPanol[]= $auxx; 
        }
    }

    public function devuelto($herramienta,$idPanol)
    {
        if($herramienta["tipo"] == "personal")
        {
            $h= new HerramientaPersonal();
            $h->devuelto($herramienta["id"]);
        }else{
            $h= new HerramientaMaquina();
            $h->devuelto($herramienta["id"]);
        }

        $panol = ModelsPanol::find($idPanol);
        $panol->devuelto = 1;
        $panol->save();
        return redirect()->route('panol');
    }

    public function perdida($herramienta,$idPanol)
    {
        if($herramienta["tipo"] == "personal")
        {
            $h= new HerramientaPersonal();
            $h->perdida($herramienta["id"]);
        }else{
            $h= new HerramientaMaquina();
            $h->perdida($herramienta["id"]);
        }

        $panol = ModelsPanol::find($idPanol);
        $panol->devuelto = 1;
        $panol->save();
        return redirect()->route('panol');
    }

    public function rotura($herramienta,$idPanol)
    {
        if($herramienta["tipo"] == "personal")
        {
            $h= new HerramientaPersonal();
            $h->rotura($herramienta["id"]);
        }else{
            $h= new HerramientaMaquina();
            $h->rotura($herramienta["id"]);
        }

        $panol = ModelsPanol::find($idPanol);
        $panol->devuelto = 1;
        $panol->save();
        return redirect()->route('panol');
    }
}
