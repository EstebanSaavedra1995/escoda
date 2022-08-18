<?php

namespace App\Http\Controllers\Admin\Datos;

use App\Http\Controllers\Controller;
use App\Models\ArticulosGenerales;
use App\Models\Goma;
use App\Models\Material;
use Illuminate\Http\Request;

class ArticulosController extends Controller
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
        $articulos = ArticulosGenerales::all();
        $gomas = Goma::all();
        $materiales = Material::all();
        return view('admin.datos.articulos.index', compact('articulos', 'gomas', 'materiales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.datos.articulos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipo = request('tipo');
        switch ($tipo) {
            case 'a':
                $articulo = new ArticulosGenerales;
                $articulo->CodArticulo = request('codigo');
                $articulo->Descripcion = request('descripcion');
                $articulo->Stock = request('stock');
                $articulo->save();
                break;

            case 'g':
                $articulo = new Goma;
                $articulo->CodigoInterno = request('codInterno');
                $articulo->DiametroInterior = request('diaInt');
                $articulo->DiametroExterior = request('diaExt');
                $articulo->Altura = request('altura');
                $articulo->Stock = request('stock');
                $articulo->CodigoGoma = request('codGoma');
                $articulo->save();
                break;

            case 'm':
                $articulo = new Material;
                $articulo->CodigoMaterial = request('codigo');
                $articulo->Material = request('material');
                $articulo->Dimension = request('dim');
                $articulo->Calidad = request('calidad');
                $articulo->Stock = request('stock');
                $articulo->StockMaximo = request('stockMax');
                $articulo->save();

                break;

            default:
                # code...
                break;
        }

        return redirect()->route('datos.articulos.edit', $articulo)->with('info', 'El proveedor se actualizo con exito')->with('tipo', $tipo);
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
    public function edit(Request $request, $id)
    {
        //   $tipo = request('tipo');
        if (request('tipo')) {
            $tipo = request('tipo');
        } else {
            $tipo = session('tipo');
        }
        switch ($tipo) {
            case 'a':
                $articulo = ArticulosGenerales::find($id);
                break;

            case 'g':
                $articulo = Goma::find($id);
                break;

            case 'm':
                $articulo = Material::find($id);
                break;

            default:
                # code...
                break;
        }

        return view('admin.datos.articulos.edit', compact('articulo', 'tipo'));
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

        $tipo = request('tipo');
        switch ($tipo) {
            case 'a':
                $articulo = ArticulosGenerales::find($id);
                $articulo->CodArticulo = request('codigo');
                $articulo->Descripcion = request('descripcion');
                $articulo->Stock = request('stock');
                $articulo->save();
                break;

            case 'g':
                $articulo = Goma::find($id);
                $articulo->CodigoInterno = request('codInterno');
                $articulo->DiametroInterior = request('diaInt');
                $articulo->DiametroExterior = request('diaExt');
                $articulo->Altura = request('altura');
                $articulo->Stock = request('stock');
                $articulo->CodigoGoma = request('codGoma');
                $articulo->save();
                break;

            case 'm':
                $articulo = Material::find($id);
                $articulo->CodigoMaterial = request('codigo');
                $articulo->Material = request('material');
                $articulo->Dimension = request('dim');
                $articulo->Calidad = request('calidad');
                $articulo->Stock = request('stock');
                $articulo->StockMaximo = request('stockMax');
                $articulo->save();

                break;

            default:
                # code...
                break;
        }

        return redirect()->route('datos.articulos.edit', $id)->with('info', 'El proveedor se actualizo con exito')->with('tipo', $tipo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipo = request('tipo');

        switch ($tipo) {
            case 'a':
                $articulo = ArticulosGenerales::find($id);
                $articulo->delete();
                return redirect()->route('datos.articulos.index')->with('info', 'El artículo se elimino con exito');
                break;

            case 'g':
                $articulo = Goma::find($id);
                $articulo->delete();
                return redirect()->route('datos.articulos.index')->with('info', 'La goma se elimino con exito');
                break;

            case 'm':
                $articulo = Material::find($id);
                $articulo->delete();
                return redirect()->route('datos.articulos.index')->with('info', 'El material se elimino con exito');
                break;

            default:
                # code...
                break;
        }
    }
}
