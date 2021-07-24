<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrazabilidadConjuntos extends Model
{
    use HasFactory;
    public $timestamps = false;
    //protected $primaryKey = 'CodPieza';
    protected $table= 'trazabilidadconjuntos';
}
