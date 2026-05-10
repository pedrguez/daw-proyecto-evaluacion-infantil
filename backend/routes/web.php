<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () { // Ruta principal
    return view('welcome');
});

require __DIR__.'/auth.php'; // Importamos las rutas de autenticación (registro, login, etc)
