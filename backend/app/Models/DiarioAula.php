<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiarioAula extends Model
{
    use HasFactory;

    protected $fillable = ['fecha', 'contenido'];
}
