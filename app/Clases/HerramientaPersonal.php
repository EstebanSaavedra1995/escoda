<?php

namespace App\Clases;

use App\Models\Herramientas;


class HerramientaPersonal extends Herramientas
{

    public function guardar($herramienta)
    {
        // for ($i=0; $i < $cantidad; $i++) { 
        $h = new Herramientas();
        $h->codigo = $herramienta->codigo;
        $h->descripcion = $herramienta->descripcion;
        $h->tipo = $herramienta->tipo;
        $h->inserto = $herramienta->inserto;
        $h->sentido = $herramienta->sentido;
        $h->medida = $herramienta->medida;
        $h->estado = "";
        $h->stock = $herramienta->stock;
        $h->save();
        return $h;
    }
    public function actualizar($herramienta, $id)
    {
        // for ($i=0; $i < $cantidad; $i++) { 
        $h = Herramientas::find($id);
        $h->codigo = $herramienta->codigo;
        $h->descripcion = $herramienta->descripcion;
        $h->tipo = $herramienta->tipo;
        $h->inserto = $herramienta->inserto;
        $h->sentido = $herramienta->sentido;
        $h->medida = $herramienta->medida;
        $h->stock = $herramienta->stock;
        //$h->estado = $herramienta->estado;
        $h->save();
        return $h;
    }

    public function devuelto($id)
    {
        $herramienta = Herramientas::find($id);
        $herramienta->stock += 1;
        $herramienta->save();
    }

    public function perdida($id)
    {
        $herramienta = Herramientas::find($id);
        //$herramienta->stock -= 1;
        $herramienta->save();
    }

    public function rotura($id)
    {
        $herramienta = Herramientas::find($id);
        //$herramienta->stock -= 1;
        $herramienta->save();
    }
}
