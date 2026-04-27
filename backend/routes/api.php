<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorPrueba;

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
