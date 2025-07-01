<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibroController;
use Illuminate\Support\Facades\DB;

// Redirección inicial
Route::redirect('/', '/auth/login');

// Rutas de autenticación básica
Route::prefix('auth')->group(function() {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Rutas de libros (acceso básico sin middlewares complejos)
Route::prefix('libros')->group(function() {
    Route::get('/', [LibroController::class, 'index'])->name('libros.index');
    Route::get('/create', [LibroController::class, 'create'])->name('libros.create');
    Route::post('/', [LibroController::class, 'store'])->name('libros.store');
});

// Ruta de prueba para verificar conexión a Oracle (opcional)
Route::get('/test-oracle', function() {
    try {
        $user = DB::selectOne("SELECT * FROM usuarios WHERE email = 'admin@biblioteca.com'");
        return response()->json($user ?: ['error' => 'Usuario no encontrado']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});