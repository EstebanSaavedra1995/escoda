<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiezaDeConjunto extends Model
{
    use HasFactory;
    
    /* alter table piezadeconjunto drop primary key;
ALTER TABLE piezadeconjunto ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    protected $table= 'piezadeconjunto';
    public $timestamps = false;

}
