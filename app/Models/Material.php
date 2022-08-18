<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    /* alter table materiales drop primary key;
ALTER TABLE materiales ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    public $timestamps = false;
    protected $table = 'materiales';
}
