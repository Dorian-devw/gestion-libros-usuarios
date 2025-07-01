<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibroController;

// Ruta de acceso directo a todas las vistas
Route::get('/acceso-directo', function() {
    // Simulamos un usuario bibliotecario
    session(['usuario' => [
        'id' => 1,
        'nombre' => 'Admin',
        'email' => 'admin@biblioteca.com',
        'rol' => 'BIBLIOTECARIO'
    ]]);
    
    return redirect()->route('libros.index');
});

// Rutas públicas
Route::redirect('/', '/auth/login');
Route::prefix('auth')->group(function() {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

// Rutas de libros (accesibles directamente)
Route::prefix('libros')->group(function() {
    Route::get('/', [LibroController::class, 'index'])->name('libros.index');
    Route::get('/create', [LibroController::class, 'create'])->name('libros.create');
    Route::post('/', [LibroController::class, 'store'])->name('libros.store');
});

// Ruta para simular datos
Route::get('/simular-datos', function() {
    $autores = [
        (object)['AUTOR_ID' => 1, 'NOMBRE' => 'Gabriel García Márquez'],
        (object)['AUTOR_ID' => 2, 'NOMBRE' => 'Mario Vargas Llosa']
    ];
    
    $categorias = [
        (object)['CATEGORIA_ID' => 1, 'NOMBRE' => 'Novela'],
        (object)['CATEGORIA_ID' => 2, 'NOMBRE' => 'Ciencia Ficción']
    ];
    
    $libros = [
        ['TITULO' => 'Cien años de soledad', 'AUTOR' => 'Gabriel García Márquez', 
        'CATEGORIA' => 'Novela', 'ISBN' => '123456', 'EJEMPLARES' => 5],
        ['TITULO' => 'La ciudad y los perros', 'AUTOR' => 'Mario Vargas Llosa', 
        'CATEGORIA' => 'Novela', 'ISBN' => '789012', 'EJEMPLARES' => 3]
    ];
    
    session()->put('autores', $autores);
    session()->put('categorias', $categorias);
    session()->put('libros', $libros);
    
    return redirect()->route('libros.index');
});