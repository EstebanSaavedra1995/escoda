<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pieza extends Model
{   /* alter table piezas drop primary key
    ALTER TABLE piezas ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    protected $table= 'piezas';
    public $timestamps = false;
     // alter table 'coladamaterial' drop primary key;
    //ALTER TABLE 'coladamaterial' ADD id int NOT NULL AUTO_INCREMENT primary key FIRST
    
    
}
