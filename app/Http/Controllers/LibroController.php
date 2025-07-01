<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibroController extends Controller
{
    public function index()
    {
        $libros = DB::select("SELECT * FROM libros");
        return view('libros.index', compact('libros'));
    }
        public function create()
    {
        return view('libros.create', [
            'autores' => session('autores', []),
            'categorias' => session('categorias', [])
        ]);
    }
    
    public function store(Request $request)
    {
        // Simulamos guardar el libro
        $libros = session('libros', []);
        $libros[] = [
            'TITULO' => $request->titulo,
            'AUTOR' => collect(session('autores'))->firstWhere('AUTOR_ID', $request->autor_id)->NOMBRE,
            'CATEGORIA' => collect(session('categorias'))->firstWhere('CATEGORIA_ID', $request->categoria_id)->NOMBRE,
            'ISBN' => $request->isbn,
            'EJEMPLARES' => $request->ejemplares
        ];
        
        session()->put('libros', $libros);
        
        return redirect()->route('libros.index')->with('success', 'Libro creado exitosamente');
    }
}