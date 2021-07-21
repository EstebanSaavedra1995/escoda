<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConjuntoArticulos extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'CodPieza';
    protected $table= 'conjuntoarticulosgenerales';
}
