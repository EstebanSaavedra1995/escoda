<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrazabilidadConjuntos extends Model
{
    /*     alter table trazabilidadconjuntos drop primary key
        ALTER TABLE trazabilidadconjuntos ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    //CAMBIAR FECHAS A TIPO DATE
    //CAMBIAR VARCHAR 25 A TIPO DE EGRESO
    use HasFactory;
    public $timestamps = false;
    protected $table = 'trazabilidadconjuntos';
}
