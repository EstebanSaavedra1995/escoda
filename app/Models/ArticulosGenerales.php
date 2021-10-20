<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticulosGenerales extends Model
{
    use HasFactory;
    /* alter table detalleoc drop primary key
    ALTER TABLE detalleoc ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    protected $table= 'articulosgenerales';
    public $timestamps = false;
}
