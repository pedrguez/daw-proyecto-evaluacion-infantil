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

    // Función para obtener un alumno por ID
    public function obtenerAlumno($id) {
    $alumno = Alumno::find($id); // Busca por ID
    if (!$alumno) {
        return response()->json(['mensaje' => 'No encontrado'], 404);
    }
    return response()->json($alumno);
    }

    // Función para actualizar los datos de un alumno
    public function actualizarAlumno(Request $request, $id) {
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return response()->json(['mensaje' => 'Alumno no encontrado'], 404);
        }

        $alumno->nombre = $request->nombre;
        $alumno->apellidos = $request->apellidos;
        $alumno->fecha_nacimiento = $request->fecha_nacimiento;
        $alumno->curso = $request->curso;
        $alumno->observaciones = $request->observaciones;
        $alumno->save();

        return response()->json(['mensaje' => 'Alumno actualizado correctamente']);
    }

    // Función para dar de baja (borrar) a un alumno
    public function eliminarAlumno($id) {
        $alumno = Alumno::find($id);
        if (!$alumno) {
            return response()->json(['mensaje' => 'Alumno no encontrado'], 404);
        }

        $alumno->delete(); // Magia de Laravel: borra el registro de la base de datos
        return response()->json(['mensaje' => 'Alumno eliminado correctamente']);
    }
}
