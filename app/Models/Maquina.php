<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maquina extends Model
{
    /* alter table `maquinas` drop primary key
ALTER TABLE `maquinas` ADD CodMaquina int NOT NULL AUTO_INCREMENT primary key FIRST  */
    use HasFactory;
    public $timestamps = false;
    protected $table= 'maquinas';
    protected $primaryKey = 'CodMaquina';
}
