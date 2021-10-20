<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goma extends Model
{
    /* alter table detalleoc drop primary key
    ALTER TABLE detalleoc ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    protected $table= 'gomas';
    public $timestamps = false;
}
