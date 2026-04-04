<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorPrueba;

// Cuando alguien visite la ruta /api/prueba, ejecutamos la función Saludar
Route::get('/prueba', [ControladorPrueba::class, 'Saludar']);
