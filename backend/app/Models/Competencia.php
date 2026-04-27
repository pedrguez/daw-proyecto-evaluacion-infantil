<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competencia extends Model
{
    protected $guarded = [];

    // Le enseñamos que una Competencia pertenece a un Área...
    public function area() {
        return $this->belongsTo(Area::class);
    }

    // ...y que tiene muchos Criterios
    public function criterios() {
        return $this->hasMany(Criterio::class);
    }
}
