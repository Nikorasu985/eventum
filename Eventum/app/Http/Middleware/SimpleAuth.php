<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class SimpleAuth
{
    public function handle(Request $request, Closure $next)
    {
        $usuarioId = session('usuario_id');
        
        if (!$usuarioId) {
            return redirect()->route('login');
        }
        
        $usuario = Usuario::find($usuarioId);
        if (!$usuario) {
            session()->forget('usuario_id');
            return redirect()->route('login');
        }
        
        // Configurar el usuario autenticado
        Auth::setUser($usuario);
        $request->merge(['usuario' => $usuario]);
        $request->setUserResolver(function () use ($usuario) {
            return $usuario;
        });
        
        return $next($request);
    }
}
