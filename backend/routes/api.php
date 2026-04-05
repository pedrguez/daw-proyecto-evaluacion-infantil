<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorPrueba;

// Ruta de prueba inicial
Route::get('/prueba', [ControladorPrueba::class, 'Saludar']);

// Nuevas rutas para los Alumnos
Route::get('/alumnos', [ControladorPrueba::class, 'listarAlumnos']); // Pedir datos (GET)
Route::post('/alumnos', [ControladorPrueba::class, 'guardarAlumno']); // Enviar datos (POST)
Route::get('/alumnos/{id}', [ControladorPrueba::class, 'obtenerAlumno']); // Obtener un alumno por ID (GET)
