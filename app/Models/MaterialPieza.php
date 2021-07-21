<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPieza extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'codigoPieza';
    protected $table= 'piezamaterial';
}
