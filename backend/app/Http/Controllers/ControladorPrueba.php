<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorPrueba extends Controller
{
    public function Saludar() {
        return response()->json([
            'mensaje' => 'Soy tu ControladorPrueba de Laravel. Nuestra API funciona perfectamente.'
        ]);
    }
}
