<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedorFactura extends Model
{
    /* alter table proveedorfacturas drop primary key;
    ALTER TABLE proveedorfacturas ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */

    use HasFactory;
    public $timestamps = false;
    protected $table= 'proveedorfacturas';
}
