<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno; // Importamos el modelo de Alumno

class ControladorPrueba extends Controller
{
    // Mantiene la prueba de conexión original por si la necesitas
    public function Saludar() {
        return response()->json([
            'mensaje' => '¡Hola! Soy tu ControladorPrueba de Laravel. Nuestra API funciona perfecto. 🚀'
        ]);
    }

    // Función para listar todos los alumnos
    public function listarAlumnos() {
        return response()->json(Alumno::all());
    }

    // Función para guardar un alumno nuevo
    public function guardarAlumno(Request $request) {
        $alumno = new Alumno();
        $alumno->nombre = $request->nombre;
        $alumno->apellidos = $request->apellidos;
        $alumno->fecha_nacimiento = $request->fecha_nacimiento;
        $alumno->curso = $request->curso;
        $alumno->observaciones = $request->observaciones;

        $alumno->save();

        return response()->json(['mensaje' => 'Alumno guardado correctamente']);
    }
}
