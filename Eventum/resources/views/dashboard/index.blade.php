@extends('layouts.principal')

@section('title', 'Dashboard - Eventum')

@section('content')
<div class="fade-in">
    <!-- Header del Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
                    <h1 class="display-4 fw-bold mb-2">
                        <span class="gradient-text">
                            ¡Bienvenido, {{ Auth::user()->nombre_usuario }}!
                        </span>
                    </h1>
            <p class="text-muted fs-5">Gestiona tus eventos de manera inteligente</p>
        </div>
        <div class="d-flex gap-3">
            <a href="{{ route('eventos.create') }}" class="btn btn-primary pulse">
                <i class="fas fa-plus me-2"></i>
                Crear Evento
            </a>
            <button class="btn btn-accent" onclick="abrirUnirseEvento()">
                <i class="fas fa-key me-2"></i>
                Unirse por Código
            </button>
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <div class="bg-gradient-primary rounded-circle p-3">
                                <img src="{{ asset('logo.png') }}" alt="Eventum" class="stat-logo">
                            </div>
                        </div>
                        <div>
                            <div class="stat-value">{{ $totalEventosCreados }}</div>
                            <div class="stat-label">Eventos Creados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <div class="bg-gradient-secondary rounded-circle p-3">
                                <i class="fas fa-users text-white fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <div class="stat-value">{{ $participando }}</div>
                            <div class="stat-label">Participando</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <div class="bg-gradient-accent rounded-circle p-3">
                                <i class="fas fa-envelope text-white fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <div class="stat-value">{{ $invitacionesPendientes }}</div>
                            <div class="stat-label">Invitaciones</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <div class="bg-gradient-warning rounded-circle p-3">
                                <i class="fas fa-bell text-white fs-4"></i>
                            </div>
                        </div>
                        <div>
                            <div class="stat-value">{{ $notificacionesNoLeidas }}</div>
                            <div class="stat-label">Notificaciones</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('eventos.create') }}" class="btn btn-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-plus-circle fs-1 mb-2"></i>
                                <span class="fw-bold">Crear Evento</span>
                                <small class="text-white-50">Nuevo evento</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <button class="btn btn-accent w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4" onclick="abrirUnirseEvento()">
                                <i class="fas fa-key fs-1 mb-2"></i>
                                <span class="fw-bold">Unirse por Código</span>
                                <small class="text-white-50">Código de evento</small>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('eventos.index') }}" class="btn btn-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-calendar-alt fs-1 mb-2"></i>
                                <span class="fw-bold">Mis Eventos</span>
                                <small class="text-white-50">Gestionar eventos</small>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('configuracion.index') }}" class="btn btn-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-cog fs-1 mb-2"></i>
                                <span class="fw-bold">Configuración</span>
                                <small class="text-white-50">Personalizar</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="row">
        <!-- Eventos Próximos -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-check me-2 text-primary"></i>
                        Eventos Próximos
                    </h5>
                    <a href="{{ route('eventos.index') }}" class="btn btn-sm btn-outline-primary">
                        Ver todos
                    </a>
                </div>
                <div class="card-body">
                    @forelse($eventosProximos as $evento)
                        <div class="evento-item mb-3 p-3 border rounded">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h6 class="mb-0">{{ $evento->titulo }}</h6>
                                        @if($evento->id_anfitrion == Auth::id())
                                            <span class="badge bg-primary">Anfitrión</span>
                                        @else
                                            <span class="badge bg-success">Participante</span>
                                        @endif
                                    </div>
                                    <p class="text-muted mb-2">{{ Str::limit($evento->descripcion, 100) }}</p>
                                    <div class="d-flex gap-3">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $evento->fecha_inicio->format('d M Y') }}
                                        </small>
                                        @if($evento->hora_inicio)
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $evento->hora_inicio }}
                                            </small>
                                        @endif
                                        @if($evento->lugar)
                                            <small class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ Str::limit($evento->lugar, 30) }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($evento->id_anfitrion == Auth::id())
                                        <a href="{{ route('eventos.edit', $evento->id_evento) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-plus text-muted fs-1 mb-3"></i>
                            <h5 class="text-muted">No tienes eventos próximos</h5>
                            <p class="text-muted">¡Crea tu primer evento para comenzar!</p>
                            <a href="{{ route('eventos.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Crear Evento
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Panel Lateral -->
        <div class="col-lg-4">
            <!-- Notificaciones Recientes -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-bell me-2 text-warning"></i>
                        Notificaciones Recientes
                    </h6>
                    <a href="{{ route('notificaciones.index') }}" class="btn btn-sm btn-outline-primary">
                        Ver todas
                    </a>
                </div>
                <div class="card-body">
                    @forelse($notificacionesRecientes as $notificacion)
                        <div class="notification-item mb-3 p-2 {{ !$notificacion->leida ? 'bg-light rounded' : '' }}">
                            <div class="d-flex align-items-start">
                                <div class="bg-gradient-primary rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-bell text-white" style="font-size: 0.8rem;"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <p class="mb-1 small">{{ Str::limit($notificacion->contenido, 80) }}</p>
                                    <small class="text-muted">{{ $notificacion->fecha_envio->diffForHumans() }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="fas fa-bell-slash text-muted fs-3 mb-2"></i>
                            <p class="text-muted small">No hay notificaciones</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Cosas por Llevar Pendientes -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-list me-2 text-success"></i>
                        Cosas por Llevar
                    </h6>
                    <a href="{{ route('lista.index') }}" class="btn btn-sm btn-outline-primary">
                        Ver todas
                    </a>
                </div>
                <div class="card-body">
                    @forelse($cosasPorLlevar as $cosa)
                        <div class="cosa-item mb-2 p-2 border rounded">
                            <div class="d-flex align-items-center">
                                <div class="form-check me-2">
                                    <input class="form-check-input" type="checkbox" {{ $cosa->estado === 'comprado' ? 'checked' : '' }}>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">{{ $cosa->nombre }}</h6>
                                    @if($cosa->cantidad)
                                        <small class="text-muted">{{ $cosa->cantidad }}</small>
                                    @endif
                                </div>
                                <span class="badge bg-{{ $cosa->estado === 'comprado' ? 'success' : 'warning' }} small">
                                    {{ ucfirst($cosa->estado) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-3">
                            <i class="fas fa-list text-muted fs-3 mb-2"></i>
                            <p class="text-muted small">No hay elementos pendientes</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para unirse por código -->
<div class="modal fade" id="unirseEventoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Unirse a Evento por Código</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('eventos.unirse-codigo') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Código del Evento</label>
                        <input type="text" class="form-control" name="codigo_evento" placeholder="Ingresa el código del evento" required>
                        <div class="form-text">El código debe ser proporcionado por el organizador del evento</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Unirse al Evento</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .stat-card {
        transition: var(--transition);
        border-left: 4px solid var(--primary-color);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px var(--shadow);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 800;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 0.5rem;
    }

    .evento-item {
        transition: var(--transition);
        background: var(--bg-tertiary);
    }

    .evento-item:hover {
        background: var(--bg-secondary);
        transform: translateX(4px);
    }

    .notification-item {
        transition: var(--transition);
    }

    .cosa-item {
        transition: var(--transition);
    }

    .cosa-item:hover {
        background: var(--bg-tertiary);
    }

    .stat-logo {
        width: 24px;
        height: 24px;
        object-fit: contain;
        filter: brightness(0) invert(1);
    }
</style>

<script>
    function abrirUnirseEvento() {
        const modal = new bootstrap.Modal(document.getElementById('unirseEventoModal'));
        modal.show();
    }
</script>
@endsection

@section('styles')
<style>
    .stat-label {
        font-size: 0.9rem;
        color: var(--text-muted) !important;
        font-weight: 500;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary) !important;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-primary) !important;
        margin-bottom: 1.5rem;
    }

    .card-title {
        color: var(--text-primary) !important;
    }

    .card-text {
        color: var(--text-secondary) !important;
    }

    .text-muted {
        color: var(--text-muted) !important;
    }

    .badge {
        color: white !important;
    }

    .btn {
        color: white !important;
    }

    .btn-outline-primary {
        color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }

    .btn-outline-primary:hover {
        color: white !important;
        background-color: var(--primary-color) !important;
    }

    .list-group-item {
        background: var(--bg-secondary) !important;
        border-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }

    .list-group-item:hover {
        background: var(--bg-tertiary) !important;
    }

    .event-card {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
    }

    .event-card .card-title {
        color: var(--text-primary) !important;
    }

    .event-card .card-text {
        color: var(--text-secondary) !important;
    }

    .stat-card {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
    }

    .stat-card .card-body {
        color: var(--text-primary) !important;
    }

    .quick-actions .btn {
        color: white !important;
    }

    .quick-actions .btn-outline-primary {
        color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }

    .quick-actions .btn-outline-primary:hover {
        color: white !important;
        background-color: var(--primary-color) !important;
    }
</style>
@endsection