<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    /* alter table tareas drop primary key;
ALTER TABLE tareas ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    public $timestamps = false;
    protected $table= 'tareas';
}
