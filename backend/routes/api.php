<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorPrueba;

// --- ZONA PROTEGIDA (SOLO USUARIOS LOGUEADOS) ---
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Rutas para Gestión de Personal(profesorado)
    Route::get('/users', [ControladorPrueba::class, 'listarUsuarios']);
    Route::post('/users', [ControladorPrueba::class, 'guardarUsuario']);
    Route::put('/users/{id}', [ControladorPrueba::class, 'actualizarUsuario']); // Para Editar
    Route::delete('/users/{id}', [ControladorPrueba::class, 'eliminarUsuario']); // Para Borrar

});
// ------------------------------------------------


// Ruta de prueba inicial
Route::get('/prueba', [ControladorPrueba::class, 'Saludar']);

// Nuevas rutas para los Alumnos
Route::get('/alumnos', [ControladorPrueba::class, 'listarAlumnos']); // Pedir datos (GET)
Route::post('/alumnos', [ControladorPrueba::class, 'guardarAlumno']); // Enviar datos (POST)
Route::get('/alumnos/{id}', [ControladorPrueba::class, 'obtenerAlumno']); // Obtener un alumno por ID (GET)

// Rutas de Edición y Borrado
Route::put('/alumnos/{id}', [ControladorPrueba::class, 'actualizarAlumno']); // PUT es para actualizar
Route::delete('/alumnos/{id}', [ControladorPrueba::class, 'eliminarAlumno']); // DELETE es para borrar

// Ruta para guardar la evaluación (usamos POST porque estamos enviando un paquete de datos grande)
Route::post('/evaluacion', [ControladorPrueba::class, 'guardarEvaluacion']);
Route::get('/rubricas', [ControladorPrueba::class, 'obtenerRubricas']);

// Ruta para obtener las áreas con sus competencias y criterios
Route::get('/evaluacion/{alumno_id}/{trimestre}', [ControladorPrueba::class, 'obtenerNotas']);

// Ruta para obtener TODAS las notas de un alumno (para el boletín)
Route::get('/alumnos/{id}/notas', [ControladorPrueba::class, 'obtenerTodasLasNotas']);

// Rutas para el Diario de Aula
Route::get('/diario', [App\Http\Controllers\DiarioAulaController::class, 'index']);
Route::post('/diario', [App\Http\Controllers\DiarioAulaController::class, 'store']);

require __DIR__.'/auth.php';
