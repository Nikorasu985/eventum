<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participacion;
use App\Models\Evento;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class ParticipacionController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $participaciones = Participacion::where('id_usuario', $usuario->id_usuario)
            ->with(['evento.anfitrion', 'estadoParticipacion'])
            ->orderBy('fecha_confirmacion', 'desc')
            ->paginate(10);

        return view('participaciones.index', compact('participaciones'));
    }

    public function confirmar($id)
    {
        $participacion = Participacion::findOrFail($id);
        
        if ($participacion->id_usuario !== Auth::id()) {
            abort(403, 'No tienes permisos para confirmar esta participación');
        }

        $participacion->id_estado_participacion = 1; // Confirmada
        $participacion->save();

        // Notificar al anfitrión
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $participacion->evento->id_anfitrion;
        $notificacion->id_evento = $participacion->id_evento;
        $notificacion->id_tipo_notificacion = 3; // Evento
        $notificacion->contenido = Auth::user()->nombre_usuario . " ha confirmado su participación en: " . $participacion->evento->titulo;
        $notificacion->save();

        return back()->with('success', 'Participación confirmada exitosamente');
    }

    public function cancelar($id)
    {
        $participacion = Participacion::findOrFail($id);
        
        if ($participacion->id_usuario !== Auth::id()) {
            abort(403, 'No tienes permisos para cancelar esta participación');
        }

        $participacion->id_estado_participacion = 3; // Cancelada
        $participacion->save();

        // Notificar al anfitrión
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $participacion->evento->id_anfitrion;
        $notificacion->id_evento = $participacion->id_evento;
        $notificacion->id_tipo_notificacion = 3; // Evento
        $notificacion->contenido = Auth::user()->nombre_usuario . " ha cancelado su participación en: " . $participacion->evento->titulo;
        $notificacion->save();

        return back()->with('success', 'Participación cancelada');
    }

    public function marcarNoAsistio($id)
    {
        $participacion = Participacion::findOrFail($id);
        
        if ($participacion->id_usuario !== Auth::id()) {
            abort(403, 'No tienes permisos para marcar esta participación');
        }

        $participacion->id_estado_participacion = 2; // No asistió
        $participacion->save();

        return back()->with('success', 'Participación marcada como no asistió');
    }
}