<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $notificaciones = Notificacion::where('id_usuario', $usuario->id_usuario)
            ->with(['evento', 'tipoNotificacion'])
            ->orderBy('fecha_envio', 'desc')
            ->paginate(15);

        return view('notificaciones.index', compact('notificaciones'));
    }

    public function marcarLeida($id)
    {
        $usuario = Auth::user();
        $notificacion = Notificacion::findOrFail($id);
        
        if ($notificacion->id_usuario !== $usuario->id_usuario) {
            abort(403, 'No tienes permisos para marcar esta notificación');
        }

        $notificacion->leida = true;
        $notificacion->save();

        return response()->json(['success' => true]);
    }

    public function marcarTodasLeidas()
    {
        $usuario = Auth::user();
        Notificacion::where('id_usuario', $usuario->id_usuario)
            ->where('leida', false)
            ->update(['leida' => true]);

        return back()->with('success', 'Todas las notificaciones han sido marcadas como leídas');
    }
}
