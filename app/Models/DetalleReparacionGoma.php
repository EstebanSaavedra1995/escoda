<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleReparacionGoma extends Model
{
    // alter table 'coladamaterial' drop primary key;
    //ALTER TABLE 'coladamaterial' ADD id int NOT NULL AUTO_INCREMENT primary key FIRST
    //CAMBIAR COD GOMA a 25 caracteres
    use HasFactory;
    protected $table = 'detallereparaciongomas';
    public $timestamps = false;
}
