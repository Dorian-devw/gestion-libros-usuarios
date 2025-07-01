<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Libro
{
    public static function crear($datos)
    {
        return DB::executeProcedure(
            "BEGIN pkg_libros.crear_libro(:titulo, :autor_id, :categoria_id, :isbn, :ejemplares, :resultado, :mensaje); END;",
            [
                'titulo' => $datos['titulo'],
                'autor_id' => $datos['autor_id'],
                'categoria_id' => $datos['categoria_id'],
                'isbn' => $datos['isbn'],
                'ejemplares' => $datos['ejemplares'],
                'resultado' => 0,
                'mensaje' => ''
            ]
        );
    }
    
    public static function listar()
    {
        $result = DB::executeProcedure(
            "BEGIN pkg_libros.obtener_libros(:cursor); END;",
            ['cursor' => null]
        );
        
        return $result['cursor'];
    }
}