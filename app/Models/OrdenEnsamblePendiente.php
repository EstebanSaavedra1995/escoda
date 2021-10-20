<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenEnsamblePendiente extends Model
{
    use HasFactory;
     // alter table 'coladamaterial' drop primary key;
    //ALTER TABLE 'coladamaterial' ADD id int NOT NULL AUTO_INCREMENT primary key FIRST
    // CAMBIAR FECHA DE STRING A DATE EN BASE DE DATOS
    protected $table= 'ordenesensamblependientes';
    public $timestamps = false;
}
