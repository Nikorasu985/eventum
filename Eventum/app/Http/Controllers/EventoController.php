<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Usuario;
use App\Models\TipoPresupuesto;
use App\Models\RolEvento;
use App\Models\SolicitudInvitacion;
use App\Models\Notificacion;
use App\Models\CosaPorLlevar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class EventoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        
        // Obtener eventos creados por el usuario
        $eventosCreados = Evento::where('id_anfitrion', $usuario->id_usuario)
            ->with(['tipoPresupuesto', 'participantes'])
            ->get();
            
        // Obtener eventos en los que participa
        $eventosParticipando = $usuario->eventosParticipando()
            ->with(['tipoPresupuesto', 'participantes'])
            ->get();
            
        // Combinar y eliminar duplicados
        $eventosCollection = $eventosCreados->merge($eventosParticipando)
            ->unique('id_evento')
            ->sortByDesc('fecha_inicio')
            ->values();

        // Paginar colección combinada manualmente para soportar hasPages()/links()
        $perPage = 12;
        $page = Paginator::resolveCurrentPage() ?: 1;
        $total = $eventosCollection->count();
        $items = $eventosCollection->slice(($page - 1) * $perPage, $perPage)->values();
        $eventos = new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );

        return view('eventos.index', compact('eventos'));
    }

    public function create()
    {
        $tiposPresupuesto = TipoPresupuesto::all();
        $rolesEvento = RolEvento::all();
        
        return view('eventos.create', compact('tiposPresupuesto', 'rolesEvento'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'lugar' => 'nullable|string|max:150',
            'sitio' => 'nullable|string|max:150',
            'id_tipo_presupuesto' => 'required|exists:tipos_presupuesto,id_tipo_presupuesto',
            'presupuesto' => 'nullable|numeric|min:0',
            'fecha_inicio' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'nullable|date_format:H:i',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_fin' => 'nullable|date_format:H:i',
            'fecha_limite_invitacion' => 'nullable|date|before_or_equal:fecha_inicio'
        ]);

        $evento = new Evento();
        $evento->id_anfitrion = Auth::id();
        $evento->titulo = $request->titulo;
        $evento->descripcion = $request->descripcion;
        $evento->lugar = $request->lugar;
        $evento->sitio = $request->sitio;
        $evento->id_tipo_presupuesto = $request->id_tipo_presupuesto;
        $evento->presupuesto = $request->presupuesto;
        $evento->fecha_inicio = $request->fecha_inicio;
        $evento->hora_inicio = $request->hora_inicio;
        $evento->fecha_fin = $request->fecha_fin;
        $evento->hora_fin = $request->hora_fin;
        $evento->fecha_limite_invitacion = $request->fecha_limite_invitacion;
        $evento->generarCodigoEvento();
        $evento->save();

        return redirect()->route('eventos.show', $evento->id_evento)
            ->with('success', 'Evento creado exitosamente');
    }

    public function show($id)
    {
        $evento = Evento::with([
            'anfitrion',
            'tipoPresupuesto',
            'participantes',
            'cosasPorLlevar',
            'solicitudes.estadoSolicitud'
        ])->findOrFail($id);

        $cosasPorLlevar = $evento->cosasPorLlevar()->with('usuario')->get();
        $participantes = $evento->participantes()->get();
        
        // Obtener los roles de evento para los participantes
        $rolesEvento = \App\Models\RolEvento::all()->keyBy('id_rol_evento');
        foreach ($participantes as $participante) {
            $participante->rol_nombre = $rolesEvento->get($participante->pivot->id_rol_evento)->nombre_rol ?? 'Participante';
        }

        return view('eventos.show', compact('evento', 'cosasPorLlevar', 'participantes'));
    }

    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        $tiposPresupuesto = TipoPresupuesto::all();
        
        if ($evento->id_anfitrion !== Auth::id()) {
            abort(403, 'No tienes permisos para editar este evento');
        }

        return view('eventos.edit', compact('evento', 'tiposPresupuesto'));
    }

    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);
        
        if ($evento->id_anfitrion !== Auth::id()) {
            abort(403, 'No tienes permisos para editar este evento');
        }

        $request->validate([
            'titulo' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'lugar' => 'nullable|string|max:150',
            'sitio' => 'nullable|string|max:150',
            'id_tipo_presupuesto' => 'required|exists:tipos_presupuesto,id_tipo_presupuesto',
            'presupuesto' => 'nullable|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'hora_inicio' => 'nullable|date_format:H:i',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_fin' => 'nullable|date_format:H:i',
            'fecha_limite_invitacion' => 'nullable|date|before_or_equal:fecha_inicio'
        ]);

        $evento->update($request->all());

        return redirect()->route('eventos.show', $evento->id_evento)
            ->with('success', 'Evento actualizado exitosamente');
    }

    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        
        if ($evento->id_anfitrion !== Auth::id()) {
            abort(403, 'No tienes permisos para eliminar este evento');
        }

        $evento->delete();

        return redirect()->route('eventos.index')
            ->with('success', 'Evento eliminado exitosamente');
    }

    public function unirsePorCodigo(Request $request)
    {
        $request->validate([
            'codigo_evento' => 'required|string|exists:eventos,codigo_evento'
        ]);

        $evento = Evento::where('codigo_evento', $request->codigo_evento)->first();
        $usuario = Auth::user();

        if ($evento->participantes()->where('usuarios_eventos.id_usuario', $usuario->id_usuario)->exists()) {
            return back()->with('error', 'Ya estás participando en este evento');
        }

        $evento->participantes()->attach($usuario->id_usuario, [
            'id_rol_evento' => 2,
            'estado_invitacion' => 'aceptado'
        ]);

        $notificacion = new Notificacion();
        $notificacion->id_usuario = $evento->id_anfitrion;
        $notificacion->id_evento = $evento->id_evento;
        $notificacion->id_tipo_notificacion = 3;
        $notificacion->contenido = "{$usuario->nombre_usuario} se ha unido a tu evento: {$evento->titulo}";
        $notificacion->save();

        return redirect()->route('eventos.show', $evento->id_evento)
            ->with('success', 'Te has unido al evento exitosamente');
    }

    public function agregarCosaPorLlevar(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);
        
        if ($evento->id_anfitrion !== Auth::id()) {
            abort(403, 'No tienes permisos para agregar elementos a este evento');
        }

        $request->validate([
            'nombre' => 'required|string|max:100',
            'cantidad' => 'nullable|string|max:50',
            'observaciones' => 'nullable|string'
        ]);

        $cosa = new CosaPorLlevar();
        $cosa->id_evento = $evento->id_evento;
        $cosa->nombre = $request->nombre;
        $cosa->cantidad = $request->cantidad;
        $cosa->observaciones = $request->observaciones;
        $cosa->save();

        return back()->with('success', 'Elemento agregado a la lista exitosamente');
    }

    public function actualizarCosaPorLlevar(Request $request, $id, $cosaId)
    {
        $evento = Evento::findOrFail($id);
        $cosa = CosaPorLlevar::findOrFail($cosaId);
        
        if ($evento->id_evento !== $cosa->id_evento) {
            abort(404);
        }

        $request->validate([
            'estado' => 'required|in:pendiente,comprado,cancelado',
            'id_usuario' => 'nullable|exists:usuarios,id_usuario'
        ]);

        $cosa->estado = $request->estado;
        $cosa->id_usuario = $request->id_usuario;
        $cosa->save();

        return back()->with('success', 'Estado actualizado exitosamente');
    }
}
