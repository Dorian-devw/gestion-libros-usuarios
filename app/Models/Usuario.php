<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Usuario
{
    public static function autenticar($email, $password)
    {
        $result = DB::executeProcedure(
            "BEGIN pkg_usuarios.autenticar_usuario(:email, :password, :resultado, :usuario); END;",
            [
                'email' => $email,
                'password' => $password,
                'resultado' => 0,
                'usuario' => null
            ]
        );
        
        return $result['resultado'] == 1 ? $result['usuario'] : null;
    }
    
    public static function registrar($datos)
    {
        return DB::executeProcedure(
            "BEGIN pkg_usuarios.registrar_usuario(:nombre, :email, :password, :rol, :resultado, :mensaje); END;",
            [
                'nombre' => $datos['nombre'],
                'email' => $datos['email'],
                'password' => bcrypt($datos['password']),
                'rol' => $datos['rol'],
                'resultado' => 0,
                'mensaje' => ''
            ]
        );
    }
}