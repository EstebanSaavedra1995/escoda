<?php

namespace App\Http\Controllers\Admin\Datos;

use App\Http\Controllers\Controller;
use App\Models\Maquina;
use Illuminate\Http\Request;

class MaquinasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $maquinas = Maquina::all();
        return view('admin.datos.maquinas.index', compact('maquinas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.datos.maquinas.create');
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
            'nombreMaquina' => 'required'
        ]);

        $maquina = new Maquina();
        $maquina->NombreMaquina = strtoupper($request->nombreMaquina);
        $maquina->save();

        return redirect()->route('datos.maquinas.edit', $maquina)->with('info', 'La maquina se creo con exito');
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
        $maquina = Maquina::find($id);
        return view('admin.datos.maquinas.edit', compact('maquina'));
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
        $maquina = Maquina::find($id);
        $maquina->NombreMaquina = strtoupper($request->nombreMaquina);
        $maquina->save();
        return redirect()->route('datos.maquinas.edit', $maquina->CodMaquina)->with('info', 'La maquina se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $maquina = Maquina::find($id);
        $maquina->delete();
        return redirect()->route('datos.maquinas.index')->with('info','La maquina se elimino con exito');
    }
}
