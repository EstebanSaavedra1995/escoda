<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargos extends Model
{
/*     alter table `cargos` drop primary key
ALTER TABLE `cargos` ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    protected $table = 'cargos';
    //protected $primaryKey = 'Cargos';
    public $timestamps = false;
}
