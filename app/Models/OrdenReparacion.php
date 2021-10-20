<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenReparacion extends Model
{
    use HasFactory;
/*     alter table `ordenesreparacion` drop primary key
    ALTER TABLE `ordenesreparacion` ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    protected $table= 'ordenesreparacion';
    public $timestamps = false;
}
