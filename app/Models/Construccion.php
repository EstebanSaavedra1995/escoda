<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Construccion extends Model
{
    use HasFactory;
       /* alter table ordenesconstruccion drop primary key
ALTER TABLE ordenesconstruccion ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    public $timestamps = false;
    protected $table= 'ordenesconstruccion';
    
}
