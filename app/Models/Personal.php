<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    //ALTER TABLE personal DROP PRIMARY KEY, MODIFY NroLegajo INT AUTO_INCREMENT PRIMARY KEY;
    use HasFactory;
    protected $table= 'personal';
    protected $primaryKey = 'NroLegajo';
    public $timestamps = false;
}
