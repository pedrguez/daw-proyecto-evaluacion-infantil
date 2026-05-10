<?php
// Este archivo se encarga de las rutas relacionadas con la autenticación (registro, login, etc).
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store']) // Para registrar un nuevo usuario, llamamos a la función "store" de nuestro controlador de registro
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store']) // Para iniciar sesión, llamamos a la función "store" de nuestro controlador de autenticación
    ->middleware('guest')
    ->name('login');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']) // Para solicitar el enlace de restablecimiento de contraseña, llamamos a la función "store" de nuestro controlador de enlace de restablecimiento de contraseña
    ->middleware('guest')
    ->name('password.email');

Route::post('/reset-password', [NewPasswordController::class, 'store']) // Para restablecer la contraseña, llamamos a la función "store" de nuestro controlador de nueva contraseña
    ->middleware('guest')
    ->name('password.store');

Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class) // Para verificar el email, llamamos a la función __invoke de nuestro controlador de verificación
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store']) // Para reenviar el email de verificación
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']) // Para cerrar sesión, llamamos a la función "destroy" de nuestro controlador de autenticación
    ->middleware('auth')
    ->name('logout');
