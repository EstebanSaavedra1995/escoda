<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaArticulos extends Model
{
    /* alter table facturaarticulos drop primary key
ALTER TABLE facturaarticulos ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    protected $table = 'facturaarticulos';
    public $timestamps = false;
}
