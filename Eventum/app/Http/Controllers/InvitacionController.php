<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudInvitacion;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class InvitacionController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $invitaciones = SolicitudInvitacion::where('id_usuario', $usuario->id_usuario)
            ->with(['evento.anfitrion', 'estadoSolicitud'])
            ->orderBy('fecha_envio', 'desc')
            ->paginate(10);

        return view('invitaciones.index', compact('invitaciones'));
    }

    public function aceptar($id)
    {
        $invitacion = SolicitudInvitacion::findOrFail($id);
        
        if ($invitacion->id_usuario !== Auth::id()) {
            abort(403, 'No tienes permisos para aceptar esta invitación');
        }

        $invitacion->id_estado_solicitud = 2; // Aceptada
        $invitacion->save();

        // Crear participación
        $invitacion->evento->participantes()->attach(Auth::id(), [
            'id_rol_evento' => 2,
            'estado_invitacion' => 'aceptado'
        ]);

        // Notificar al anfitrión
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $invitacion->evento->id_anfitrion;
        $notificacion->id_evento = $invitacion->id_evento;
        $notificacion->id_tipo_notificacion = 1;
        $notificacion->contenido = Auth::user()->nombre_usuario . " ha aceptado tu invitación al evento: " . $invitacion->evento->titulo;
        $notificacion->save();

        return back()->with('success', 'Invitación aceptada exitosamente');
    }

    public function rechazar($id)
    {
        $invitacion = SolicitudInvitacion::findOrFail($id);
        
        if ($invitacion->id_usuario !== Auth::id()) {
            abort(403, 'No tienes permisos para rechazar esta invitación');
        }

        $invitacion->id_estado_solicitud = 3; // Rechazada
        $invitacion->save();

        // Notificar al anfitrión
        $notificacion = new Notificacion();
        $notificacion->id_usuario = $invitacion->evento->id_anfitrion;
        $notificacion->id_evento = $invitacion->id_evento;
        $notificacion->id_tipo_notificacion = 1;
        $notificacion->contenido = Auth::user()->nombre_usuario . " ha rechazado tu invitación al evento: " . $invitacion->evento->titulo;
        $notificacion->save();

        return back()->with('success', 'Invitación rechazada');
    }
}
