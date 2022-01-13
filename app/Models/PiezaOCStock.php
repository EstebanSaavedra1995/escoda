<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiezaOCStock extends Model
{
    use HasFactory;
    protected $table= 'piezaocstock';
    public $timestamps = false;
    /* alter table piezaocstock drop primary key;
ALTER TABLE piezaocstock ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    
    
}
