<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiarioAula;

class DiarioAulaController extends Controller
{
    // Obtener todas las notas (de la más nueva a la más antigua)
    public function index() {
        return response()->json(DiarioAula::orderBy('fecha', 'desc')->get());
    }

    // Guardar una nueva nota
    public function store(Request $request) {
        $request->validate([
            'fecha' => 'required|date',
            'contenido' => 'required|string'
        ]);

        $nota = DiarioAula::create([
            'fecha' => $request->fecha,
            'contenido' => $request->contenido
        ]);

        return response()->json($nota);
    }
}
