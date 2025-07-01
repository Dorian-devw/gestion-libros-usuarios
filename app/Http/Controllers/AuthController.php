<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $user = DB::selectOne(
            "SELECT * FROM usuarios WHERE email = ? AND password = ?",
            [$request->email, $request->password]
        );

        if ($user) {
            session(['usuario' => [
                'id' => $user->USUARIO_ID,
                'nombre' => $user->NOMBRE,
                'email' => $user->EMAIL,
                'rol' => $user->ROL
            ]]);
            return redirect()->route('libros.index');
        }

        return back()->with('error', 'Credenciales incorrectas');
    }

        
    public function showRegister()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'password' => 'required|min:6',
            'rol' => 'required|in:BIBLIOTECARIO,USUARIO'
        ]);

        $result = DB::executeProcedure(
            "BEGIN pkg_usuarios.registrar_usuario(:nombre, :email, :password, :rol, :resultado, :mensaje); END;",
            [
                'nombre' => $request->nombre,
                'email' => $request->email,
                'password' => $request->password, 
                'rol' => $request->rol,
                'resultado' => 0,
                'mensaje' => ''
            ]
        );
        
        if ($result['resultado'] == 1) {
            return redirect()->route('auth.login')->with('success', $result['mensaje']);
        }
        
        return back()->with('error', $result['mensaje']);
    }
    
    public function logout()
    {
        session()->forget('usuario');
        return redirect()->route('auth.login');
    }
}