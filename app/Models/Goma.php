<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goma extends Model
{
/*     alter table `gomas` drop primary key
 ALTER TABLE `gomas` ADD id int NOT NULL AUTO_INCREMENT primary key FIRST */
    use HasFactory;
    protected $table= 'gomas';
}
