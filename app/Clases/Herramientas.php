<?php namespace App\Clases;
abstract class Herramientas{
    abstract public function guardar($herramienta);
    abstract public function actualizar($herramienta,$id);
    abstract public function devuelto($id);
    abstract public function perdida($id);
    abstract public function rotura($id);
}
