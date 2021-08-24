<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenesConstruccion extends Model
{
    use HasFactory;
    
    protected $table= 'ordenesconstruccion';
    public $timestamps = false;
}
