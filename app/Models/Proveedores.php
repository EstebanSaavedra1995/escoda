<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    /* alter table proveedores drop primary key;
ALTER TABLE proveedores ADD CodigoProv int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    public $timestamps = false;
    protected $table = 'proveedores';
    protected $primaryKey = 'CodigoProv';
}
