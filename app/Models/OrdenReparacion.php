<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenReparacion extends Model
{
    use HasFactory;
      // alter table 'coladamaterial' drop primary key;
    //ALTER TABLE 'coladamaterial' ADD id int NOT NULL AUTO_INCREMENT primary key FIRST
    //PASAR FECHA DATE
    protected $table= 'ordenesreparacion';
    public $timestamps = false;
}
