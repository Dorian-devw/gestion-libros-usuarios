<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use PDO;
use Exception;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            // Versión simplificada y probada
            $user = DB::selectOne("
                SELECT usuario_id as id, nombre, email, rol 
                FROM usuarios 
                WHERE email = :email AND password = :password
            ", [
                'email' => $request->email,
                'password' => $request->password
            ]);

            if ($user) {
                session(['usuario' => (array)$user]);
                
                // DEBUG: Verifica la sesión
                logger('Datos de sesión:', session('usuario'));
                
                return redirect('/libros')->with('success', 'Bienvenido '.$user->nombre);
            }

            return back()->with('error', 'Credenciales incorrectas');
            
        } catch (Exception $e) {
            logger('Error en login: '.$e->getMessage());
            return back()->with('error', 'Error en el sistema');
        }
    }
        
    public function showRegister()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:usuarios,email',
            'password' => 'required|min:6|confirmed',
            'rol' => 'required|in:BIBLIOTECARIO,USUARIO'
        ]);

        try {
            $result = DB::executeProcedure(
                "BEGIN pkg_usuarios.registrar_usuario(:nombre, :email, :password, :rol, :resultado, :mensaje); END;",
                [
                    'nombre' => $request->nombre,
                    'email' => $request->email,
                    'password' => Hash::make($request->password), // Ahora con hash
                    'rol' => $request->rol,
                    'resultado' => 0,
                    'mensaje' => ''
                ]
            );
            
            if ($result['resultado'] == 1) {
                return redirect()->route('auth.login')->with('success', $result['mensaje']);
            }
            
            return back()->with('error', $result['mensaje'] ?? 'Error en el registro');
            
        } catch (Exception $e) {
            Log::error('Error en registro: '.$e->getMessage());
            return back()->with('error', 'Error en el sistema');
        }
    }
    
    public function logout()
    {
        try {
            session()->forget('usuario');
            return redirect()->route('auth.login')->with('success', 'Sesión cerrada');
        } catch (Exception $e) {
            Log::error('Error en logout: '.$e->getMessage());
            return back()->with('error', 'Error al cerrar sesión');
        }
    }
}