<?php

namespace App\Http\Controllers\Admin\Datos;

use App\Http\Controllers\Controller;
use App\Models\Cargos;
use App\Models\Personal;
use Illuminate\Http\Request;

class PersonalController extends Controller
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
        $personal = Personal::all();
        return view('admin.datos.personal.index', compact('personal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cargos = Cargos::all();
        return view('admin.datos.personal.create', compact('cargos'));
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
            'nombre' => 'required'
        ]);

        $empleado = new Personal();
        $empleado->ApellidoNombre = $request->nombre;
        $empleado->Cargo = $request->cargo;
        $fecha = date_create($request->fecha);
        $empleado->FechaIngreso = date_format($fecha, "d/m/Y");
        $empleado->Estado = $request->estado;
        $empleado->save();

        return redirect()->route('datos.personal.edit', $empleado)->with('info', 'El rol se creo con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($persona)
    {
        $empleado = Personal::where('NroLegajo', $persona)->first();
        $fecha = $this->formatoUniversal($empleado->FechaIngreso);
        $fecha = date_create($fecha);
        $empleado->FechaIngreso = date_format($fecha, "Y-m-d");
        $cargos = Cargos::all();
        return view('admin.datos.personal.edit', compact(['cargos', 'empleado']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $personal)
    {
        $empleado = Personal::where('NroLegajo',$personal)->first();
        $empleado->ApellidoNombre = $request->nombre;
        $empleado->Cargo = $request->cargo;
        $fecha = date_create($request->fecha);
        $empleado->FechaIngreso = date_format($fecha, "d/m/Y");
        $empleado->Estado = $request->estado;
        $empleado->save();
        return redirect()->route('datos.personal.edit', $empleado)->with('info', 'El rol se actualizo con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado = Personal::where('NroLegajo',$id)->first();
        $empleado->delete();
        return redirect()->route('datos.personal.index')->with('info','El empleado se elimino con exito');
    }

    public function formatoUniversal($fecha)
    {
        $fechaPartes = explode("/", $fecha);
        $fecha = $fechaPartes[2].'/'.$fechaPartes[1].'/'.$fechaPartes[0];
        return $fecha;
    }
}
