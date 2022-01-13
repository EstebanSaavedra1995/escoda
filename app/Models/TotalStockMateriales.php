<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalStockMateriales extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'totalstockmateriales';
    //ALTER TABLE totalstockmateriales ADD id int NOT NULL AUTO_INCREMENT primary key FIRST
}
