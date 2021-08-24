<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOC extends Model
{
    use HasFactory;
    /* alter table detalleoc drop primary key
    ALTER TABLE detalleoc ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    protected $table = 'detalleoc';
    public $timestamps = false;
}
