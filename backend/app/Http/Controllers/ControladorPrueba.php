<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno; // Importamos el modelo de Alumno
use App\Models\Nota;
use App\Models\Area;

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

    // Función para recibir y guardar la rúbrica entera
    public function guardarEvaluacion(Request $request) {
        $alumno_id = $request->input('alumno_id');
        $trimestre = $request->input('trimestre');
        $notas = $request->input('notas'); // Esto será un Array con todas las celdas que pulsaste

        // Recorremos todas las notas que ha enviado Vue
        foreach ($notas as $nota) {
            // Busca si este niño ya tenía una nota en este criterio y trimestre.
            // Si la tiene, la ACTUALIZA. Si no la tiene, la CREA nueva.
            Nota::updateOrCreate(
                [
                    'alumno_id' => $alumno_id,
                    'criterio_id' => $nota['criterio_id'],
                    'trimestre' => $trimestre
                ],
                [
                    'valor' => $nota['valor']
                ]
            );
        }

        return response()->json(['mensaje' => 'Evaluación del trimestre ' . $trimestre . ' guardada con éxito.']);
    }

    // Función para enviar toda la rúbrica al Frontend
    public function obtenerRubricas() {
        // Carga ansiosa: Trae las áreas y, de paso, sus competencias y criterios
        $areas = Area::with('competencias.criterios')->get();
        return response()->json($areas);
    }

    // Función para devolver las notas de un niño en un trimestre concreto
    public function obtenerNotas($alumno_id, $trimestre) {
        $notas = Nota::where('alumno_id', $alumno_id)
                     ->where('trimestre', $trimestre)
                     ->get();

        return response()->json($notas);
    }
}
