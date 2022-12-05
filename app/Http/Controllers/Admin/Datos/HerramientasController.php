<?php

namespace App\Http\Controllers\Admin\Datos;

use App\Clases\HerramientaMaquina;
use App\Clases\HerramientaPersonal;
use App\Http\Controllers\Controller;
use App\Models\Herramientas;
use Illuminate\Http\Request;

class HerramientasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $herramientas = Herramientas::all();
        return view('admin.datos.herramientas.index', compact('herramientas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.datos.herramientas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required',
            'tipo' => 'required',
        ]);

        if ($request->tipo == "personal") {
            $h = new HerramientaPersonal();
            $herramienta = $h->guardar($request, $request->stock);
        }else{
            $h = new HerramientaMaquina();
            $herramienta = $h->guardar($request);
        }
        /* $herramienta = new Herramientas();
        $herramienta->descripcion = $request->descripcion;
        $herramienta->codigo = $request->codigo;
        $herramienta->stock = $request->stock;
        $herramienta->tipo = $request->tipo;
        $herramienta->inserto = $request->inserto;
        $herramienta->sentido = $request->sentido;
        $herramienta->medida = $request->medida;
        $herramienta->save(); */

        return redirect()->route('datos.herramientas.edit', $herramienta)->with('info', 'La herramienta se creo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $herramienta = Herramientas::find($id);
        return view('admin.datos.herramientas.edit', compact(['herramienta']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required',
            'tipo' => 'required',
        ]);

        if ($request->tipo == "maquina") {
            $h = new HerramientaMaquina();
            $herramienta = $h->actualizar($request, $id);            
        }else{
            $h = new HerramientaPersonal();
            $herramienta = $h->actualizar($request, $id);
        }

        /* $herramienta = Herramientas::find($id);
        $herramienta->descripcion = $request->descripcion;
        $herramienta->codigo = $request->codigo;
        $herramienta->stock = $request->stock;
        $herramienta->tipo = $request->tipo;
        $herramienta->inserto = $request->inserto;
        $herramienta->sentido = $request->sentido;
        $herramienta->medida = $request->medida;
        $herramienta->save(); */

        return redirect()->route('datos.herramientas.edit', $herramienta)->with('info', 'La herramienta se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $herramienta = Herramientas::find($id);
        $herramienta->delete();
        return redirect()->route('datos.herramientas.index')->with('info', 'La herramienta se elimino con exito');
    }
}
