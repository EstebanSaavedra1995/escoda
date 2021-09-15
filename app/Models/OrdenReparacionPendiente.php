<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenReparacionPendiente extends Model
{
    use HasFactory;
/*     alter table `ordenesreparacionpendientes` drop primary key
    ALTER TABLE `ordenesreparacionpendientes` ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    protected $table= 'ordenesreparacionpendientes';
    public $timestamps = false;
}
