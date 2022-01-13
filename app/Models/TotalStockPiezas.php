<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalStockPiezas extends Model
{
    use HasFactory;
    /*ALTER TABLE totalstockpiezas ADD id int NOT NULL AUTO_INCREMENT primary key FIRST
    */
    public $timestamps = false;
    protected $table = 'totalstockpiezas';
}
