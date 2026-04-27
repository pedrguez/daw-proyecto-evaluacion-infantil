<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $guarded = [];

    // Le enseñamos que un Área tiene muchas Competencias
    public function competencias() {
        return $this->hasMany(Competencia::class);
    }
}
