<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function (): JsonResponse { // Ruta principal
    return response()->json([
        'message' => 'API de evaluacion infantil activa',
    ]);
});

require __DIR__.'/auth.php'; // Importamos las rutas de autenticación (registro, login, etc)
