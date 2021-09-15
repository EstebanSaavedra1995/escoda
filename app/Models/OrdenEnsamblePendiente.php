<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenEnsamblePendiente extends Model
{
    use HasFactory;
/*     alter table `ordenesensamblependientes` drop primary key
    ALTER TABLE `ordenesensamblependientes` ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    protected $table= 'ordenesensamblependientes';
    public $timestamps = false;
}
