<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenEnsamble extends Model
{
    use HasFactory;
/*     alter table `ordenesensamble` drop primary key
    ALTER TABLE `ordenesensamble` ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    protected $table= 'ordenesensamble';
    public $timestamps = false;
}
