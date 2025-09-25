<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Usuario;
use App\Models\Notificacion;
use App\Models\SolicitudInvitacion;
use App\Models\Participacion;
use App\Models\CosaPorLlevar;
use App\Models\ReporteEvento;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ConfiguracionUsuario;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        
        $totalEventosCreados = Evento::where('id_anfitrion', $usuario->id_usuario)->count();
        $participando = Evento::whereHas('participantes', function($q) use ($usuario) {
            $q->where('usuarios.id_usuario', $usuario->id_usuario);
        })->count();
        $invitacionesPendientes = SolicitudInvitacion::where('id_usuario', $usuario->id_usuario)
            ->where('id_estado_solicitud', 1)->count();
        $notificacionesNoLeidas = Notificacion::where('id_usuario', $usuario->id_usuario)
            ->where('leida', false)->count();

        // Obtener eventos próximos: creados por el usuario + eventos en los que participa
        $eventosCreados = Evento::where('id_anfitrion', $usuario->id_usuario)
            ->where('fecha_inicio', '>=', now())
            ->get();
            
        $eventosParticipando = Evento::whereHas('participantes', function($q) use ($usuario) {
            $q->where('usuarios.id_usuario', $usuario->id_usuario);
        })->where('fecha_inicio', '>=', now())->get();
            
        // Combinar y eliminar duplicados
        $eventosProximos = $eventosCreados->merge($eventosParticipando)
            ->unique('id_evento')
            ->sortBy('fecha_inicio')
            ->take(5);

        $notificacionesRecientes = Notificacion::where('id_usuario', $usuario->id_usuario)
            ->orderBy('fecha_envio', 'desc')
            ->limit(5)
            ->get();

        $cosasPorLlevar = CosaPorLlevar::whereHas('evento', function($query) use ($usuario) {
            $query->where('id_anfitrion', $usuario->id_usuario);
        })->where('estado', 'pendiente')->limit(5)->get();

        return view('dashboard.index', compact(
            'totalEventosCreados',
            'participando',
            'invitacionesPendientes',
            'notificacionesNoLeidas',
            'eventosProximos',
            'notificacionesRecientes',
            'cosasPorLlevar'
        ));
    }

    public function configuracion()
    {
        $usuario = Auth::user();
        $configuracion = $usuario->configuracion ?? new \App\Models\ConfiguracionUsuario();
        
        return view('dashboard.configuracion', compact('configuracion'));
    }

    public function actualizarConfiguracion(Request $request)
    {
        $usuario = Auth::user();
        
        $configuracion = $usuario->configuracion ?? new \App\Models\ConfiguracionUsuario();
        $configuracion->id_usuario = $usuario->id_usuario;
        $configuracion->tema = $request->tema;
        $configuracion->modo_oscuro = $request->modo_oscuro;
        $configuracion->colores_personalizados = $request->colores_personalizados;
        $configuracion->configuracion_dashboard = $request->configuracion_dashboard;
        $configuracion->notificaciones_config = $request->notificaciones_config;
        $configuracion->idioma = $request->idioma;
        $configuracion->zona_horaria = $request->zona_horaria;
        $configuracion->animaciones_habilitadas = $request->has('animaciones_habilitadas');
        $configuracion->tamaño_fuente = $request->tamaño_fuente;
        $configuracion->tipo_fuente = $request->tipo_fuente;
        $configuracion->widgets_dashboard = $request->widgets_dashboard;
        $configuracion->save();

        return response()->json(['success' => true, 'message' => 'Configuración actualizada correctamente']);
    }

    public function obtenerEstadisticas()
    {
        $usuario = Auth::user();
        
        $eventos_por_mes = Evento::where('id_anfitrion', $usuario->id_usuario)
            ->selectRaw('MONTH(fecha_inicio) as mes, COUNT(*) as total')
            ->whereYear('fecha_inicio', now()->year)
            ->groupBy('mes')
            ->get();

        $participaciones_por_mes = Participacion::whereHas('evento', function($query) use ($usuario) {
            $query->where('id_anfitrion', $usuario->id_usuario);
        })->selectRaw('MONTH(fecha_confirmacion) as mes, COUNT(*) as total')
            ->whereYear('fecha_confirmacion', now()->year)
            ->groupBy('mes')
            ->get();

        return response()->json([
            'eventos_por_mes' => $eventos_por_mes,
            'participaciones_por_mes' => $participaciones_por_mes
        ]);
    }
}
