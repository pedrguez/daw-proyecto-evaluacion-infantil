<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Criterio extends Model
{
    protected $guarded = [];

    // Le enseñamos que un Criterio pertenece a una Competencia
    public function competencia() {
        return $this->belongsTo(Competencia::class);
    }
}
