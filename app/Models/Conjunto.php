<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conjunto extends Model
{
    /* alter table conjuntos drop primary key
ALTER TABLE conjuntos ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    protected $table= 'conjuntos';
    public $timestamps = false;
    
}
