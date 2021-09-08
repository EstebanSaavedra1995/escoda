<?php

namespace App\Http\Controllers\Admin\Maquinas;

use App\Http\Controllers\Controller;
use App\Models\Maquina;
use Request;
use Cookie;

class MaquinasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cookie = Request::cookie('maquina');
        $maquinaDeEquipo = Maquina::where('CodMaquina',$cookie)->first();
        return view('admin/maquinas/index',compact('maquinaDeEquipo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $maquinas = Maquina::all();
        return view('admin/maquinas/create', compact('maquinas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($maquina)
    {
        return $maquina;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($maquina)
    {
       /*  $maq = Maquina::where('CodMaquina',$maquina);
        return $maq->CodMaquina; */
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($cod)
    {
        //$maquina = Maquina::where('CodMaquina',$cod)->first();
        $tiempo = time() + (10);
        $nueva_cookie = cookie()->forever('maquina', $cod);
        return redirect('maquinas')->withCookie($nueva_cookie);
        //$response = response("Voy a enviarte una cookie");
        //$response->withCookie($nueva_cookie);
        /* return request(view('admin/maquinas/index'))->withCookie($nueva_cookie);   */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $maquina)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($maquina)
    {
        //
    }
}
