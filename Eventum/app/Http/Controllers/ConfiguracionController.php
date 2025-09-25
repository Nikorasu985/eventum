<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConfiguracionUsuario;
use Illuminate\Support\Facades\Auth;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $configuracion = $usuario->configuracion ?? new ConfiguracionUsuario();
        
        return view('configuracion.index', compact('configuracion'));
    }

    public function actualizar(Request $request)
    {
        $usuario = Auth::user();
        
        $request->validate([
            'tema' => 'sometimes|in:futurista,neon,cyber',
            'modo_oscuro' => 'sometimes|in:light,dark,auto',
            'idioma' => 'sometimes|in:es,en,fr',
            'zona_horaria' => 'sometimes|string',
            'tamaño_fuente' => 'sometimes|integer|min:12|max:24',
            'tipo_fuente' => 'sometimes|string',
            'animaciones_habilitadas' => 'sometimes|boolean',
            'color_primario' => 'sometimes|string',
            'color_secundario' => 'sometimes|string',
            'color_acento' => 'sometimes|string'
        ]);

        $configuracion = $usuario->configuracion ?? new ConfiguracionUsuario();
        $configuracion->id_usuario = $usuario->id_usuario;
        
        // Actualizar solo los campos que se envían
        if ($request->has('tema')) {
            $configuracion->tema = $request->tema;
        }
        if ($request->has('modo_oscuro')) {
            $configuracion->modo_oscuro = $request->modo_oscuro;
        }
        if ($request->has('idioma')) {
            $configuracion->idioma = $request->idioma;
        }
        if ($request->has('zona_horaria')) {
            $configuracion->zona_horaria = $request->zona_horaria;
        }
        if ($request->has('tamaño_fuente')) {
            $configuracion->tamaño_fuente = $request->tamaño_fuente;
        }
        if ($request->has('tipo_fuente')) {
            $configuracion->tipo_fuente = $request->tipo_fuente;
        }
        if ($request->has('animaciones_habilitadas')) {
            $configuracion->animaciones_habilitadas = $request->boolean('animaciones_habilitadas');
        }
        
        // Manejar colores personalizados
        if ($request->has('color_primario') || $request->has('color_secundario') || $request->has('color_acento')) {
            $colores = json_decode($configuracion->colores_personalizados ?? '{}', true);
            if ($request->has('color_primario')) {
                $colores['primary'] = $request->color_primario;
            }
            if ($request->has('color_secundario')) {
                $colores['secondary'] = $request->color_secundario;
            }
            if ($request->has('color_acento')) {
                $colores['accent'] = $request->color_acento;
            }
            $configuracion->colores_personalizados = json_encode($colores);
        }
        
        $configuracion->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Configuración actualizada']);
        }

        return back()->with('success', 'Configuración actualizada exitosamente');
    }
}
