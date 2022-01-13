<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleReparacionPieza extends Model
{
/*     alter table detallereparacionpiezas drop primary key
ALTER TABLE detallereparacionpiezas ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    protected $table = 'detallereparacionpiezas';
    public $timestamps = false;
}
