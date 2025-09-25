<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function perfil()
    {
        $usuario = Auth::user();
        return view('usuarios.perfil', compact('usuario'));
    }

    public function actualizarPerfil(Request $request)
    {
        $usuario = Auth::user();
        
        $request->validate([
            'nombre_usuario' => 'required|string|max:100|unique:usuarios,nombre_usuario,' . $usuario->id_usuario . ',id_usuario',
            'correo' => 'required|email|max:100|unique:usuarios,correo,' . $usuario->id_usuario . ',id_usuario',
            'contraseña_actual' => 'nullable|string',
            'nueva_contraseña' => 'nullable|string|min:8|confirmed'
        ]);

        if ($request->contraseña_actual && !Hash::check($request->contraseña_actual, $usuario->contraseña)) {
            return back()->withErrors(['contraseña_actual' => 'La contraseña actual es incorrecta']);
        }

        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->correo = $request->correo;
        
        if ($request->nueva_contraseña) {
            $usuario->contraseña = Hash::make($request->nueva_contraseña);
        }
        
        $usuario->save();

        return back()->with('success', 'Perfil actualizado exitosamente');
    }
}
