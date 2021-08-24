<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColadaMaterial extends Model
{
    use HasFactory;
    /* alter table coladamaterial drop primary key
        ALTER TABLE coladamaterial ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    protected $table = 'coladamaterial';
    public $timestamps = false;
}
