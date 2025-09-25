@extends('layouts.principal')

@section('title', 'Invitaciones - Eventum')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-4 fw-bold mb-2 gradient-text">
                Invitaciones
            </h1>
            <p class="text-muted fs-5">Gestiona tus invitaciones a eventos</p>
        </div>
    </div>

    @forelse($invitaciones as $invitacion)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="flex-grow-1">
                        <h5 class="mb-2">{{ $invitacion->evento->titulo }}</h5>
                        <p class="text-muted mb-2">{{ $invitacion->evento->descripcion }}</p>
                        <div class="d-flex gap-3">
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $invitacion->evento->fecha_inicio->format('d M Y') }}
                            </small>
                            <small class="text-muted">
                                <i class="fas fa-user me-1"></i>
                                {{ $invitacion->evento->anfitrion->nombre_usuario }}
                            </small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        @if($invitacion->estadoSolicitud->nombre_estado == 'pendiente')
                            <form action="{{ route('invitaciones.aceptar', $invitacion->id_solicitud) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check me-1"></i>
                                    Aceptar
                                </button>
                            </form>
                            <form action="{{ route('invitaciones.rechazar', $invitacion->id_solicitud) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-times me-1"></i>
                                    Rechazar
                                </button>
                            </form>
                        @else
                            <span class="badge bg-{{ $invitacion->estadoSolicitud->nombre_estado == 'aceptada' ? 'success' : 'danger' }}">
                                {{ ucfirst($invitacion->estadoSolicitud->nombre_estado) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="fas fa-envelope-open text-muted fs-1 mb-3"></i>
            <h3 class="text-muted">No hay invitaciones</h3>
            <p class="text-muted">Cuando recibas invitaciones, aparecerán aquí</p>
        </div>
    @endforelse

    @if($invitaciones->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $invitaciones->links() }}
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
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

    .invitation-card {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
    }

    .invitation-card .card-title {
        color: var(--text-primary) !important;
    }

    .invitation-card .card-text {
        color: var(--text-secondary) !important;
    }

    .alert {
        color: var(--text-primary) !important;
    }

    .alert-info {
        background: rgba(79, 172, 254, 0.1) !important;
        border-left: 4px solid #4facfe !important;
        color: #4facfe !important;
    }

    .list-group-item {
        background: var(--bg-secondary) !important;
        border-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }

    .list-group-item:hover {
        background: var(--bg-tertiary) !important;
    }
</style>
@endsection
