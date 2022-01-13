<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleReparacionArticulo extends Model
{
    /* alter table detallereparacionarticulos drop primary key
ALTER TABLE detallereparacionarticulos ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    protected $table = 'detallereparacionarticulos';
    public $timestamps = false;
}
