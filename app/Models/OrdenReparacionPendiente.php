<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenReparacionPendiente extends Model
{
    use HasFactory;
      // alter table 'coladamaterial' drop primary key;
    //ALTER TABLE 'coladamaterial' ADD id int NOT NULL AUTO_INCREMENT primary key FIRST
    //cambiar Fecha a DATE
    protected $table= 'ordenesreparacionpendientes';
    public $timestamps = false;
}
