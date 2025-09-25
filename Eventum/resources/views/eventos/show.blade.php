@extends('layouts.principal')

@section('title', 'Detalles del Evento - Eventum')

@section('content')
<div class="fade-in">
    <!-- Header del Evento -->
    <div class="card mb-4">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h2 mb-2">{{ $evento->titulo }}</h1>
                    <p class="mb-0">{{ $evento->descripcion }}</p>
                </div>
                <div class="text-end">
                    <div class="badge bg-light text-dark fs-6 mb-2">{{ $evento->tipoPresupuesto->nombre_tipo }}</div>
                    <div class="small">Código: <code class="bg-light text-dark px-2 py-1 rounded">{{ $evento->codigo_evento }}</code></div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-calendar text-primary me-3 fs-4"></i>
                        <div>
                            <h6 class="mb-1">Fecha y Hora</h6>
                            <p class="mb-0">{{ $evento->fecha_inicio->format('d M Y') }} 
                                @if($evento->hora_inicio) a las {{ $evento->hora_inicio }} @endif
                            </p>
                        </div>
                    </div>
                    @if($evento->lugar)
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-map-marker-alt text-success me-3 fs-4"></i>
                            <div>
                                <h6 class="mb-1">Lugar</h6>
                                <p class="mb-0">{{ $evento->lugar }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-md-6">
                    @if($evento->presupuesto)
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-dollar-sign text-warning me-3 fs-4"></i>
                            <div>
                                <h6 class="mb-1">Presupuesto</h6>
                                <p class="mb-0">${{ number_format($evento->presupuesto, 2) }}</p>
                            </div>
                        </div>
                    @endif
                    @if($evento->sitio)
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-link text-info me-3 fs-4"></i>
                            <div>
                                <h6 class="mb-1">Sitio Web</h6>
                                <a href="{{ $evento->sitio }}" target="_blank" class="text-decoration-none">{{ $evento->sitio }}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Participantes -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-users me-2 text-primary"></i>
                        Participantes ({{ $participantes->count() }})
                    </h5>
                    <button class="btn btn-sm btn-outline-primary" onclick="invitarParticipante()">
                        <i class="fas fa-user-plus me-1"></i>
                        Invitar
                    </button>
                </div>
                <div class="card-body">
                    @forelse($participantes as $participante)
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <div class="bg-gradient-primary rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-user text-white"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $participante->nombre_usuario }}</h6>
                                <small class="text-muted">{{ $participante->rol_nombre ?? 'Participante' }}</small>
                            </div>
                            <span class="badge bg-{{ $participante->pivot->estado_invitacion == 'aceptado' ? 'success' : 'warning' }}">
                                {{ ucfirst($participante->pivot->estado_invitacion) }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-users text-muted fs-1 mb-3"></i>
                            <p class="text-muted">No hay participantes aún</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Lista de Cosas por Llevar -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2 text-success"></i>
                        Cosas por Llevar
                    </h5>
                    <button class="btn btn-sm btn-outline-success" onclick="agregarCosa()">
                        <i class="fas fa-plus me-1"></i>
                        Agregar
                    </button>
                </div>
                <div class="card-body">
                    @forelse($cosasPorLlevar as $cosa)
                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" 
                                       {{ $cosa->estado === 'comprado' ? 'checked' : '' }}
                                       onchange="actualizarCosa({{ $cosa->id_cosa }}, this.checked)">
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $cosa->nombre }}</h6>
                                @if($cosa->cantidad)
                                    <small class="text-muted">Cantidad: {{ $cosa->cantidad }}</small>
                                @endif
                            </div>
                            <span class="badge bg-{{ $cosa->estado === 'comprado' ? 'success' : 'warning' }}">
                                {{ ucfirst($cosa->estado) }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-list text-muted fs-1 mb-3"></i>
                            <p class="text-muted">No hay elementos en la lista</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones -->
    <div class="d-flex gap-3 justify-content-center">
        <a href="{{ route('eventos.edit', $evento->id_evento) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>
            Editar Evento
        </a>
        <button class="btn btn-outline-secondary" onclick="compartirEvento()">
            <i class="fas fa-share me-2"></i>
            Compartir
        </button>
        <button class="btn btn-outline-danger" onclick="eliminarEvento({{ $evento->id_evento }})">
            <i class="fas fa-trash me-2"></i>
            Eliminar
        </button>
    </div>
</div>

<!-- Modal para invitar participante -->
<div class="modal fade" id="invitarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Invitar Participante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('eventos.unirse-codigo') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Código del Evento</label>
                        <input type="text" class="form-control" value="{{ $evento->codigo_evento }}" readonly>
                        <div class="form-text">Comparte este código con los participantes</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" onclick="copiarCodigo('{{ $evento->codigo_evento }}')">
                        <i class="fas fa-copy me-2"></i>
                        Copiar Código
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para agregar cosa -->
<div class="modal fade" id="agregarCosaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Elemento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('eventos.agregar-cosa', $evento->id_evento) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del elemento</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="text" class="form-control" name="cantidad" placeholder="Ej: 2 botellas, 1 kg">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea class="form-control" name="observaciones" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function invitarParticipante() {
        const modal = new bootstrap.Modal(document.getElementById('invitarModal'));
        modal.show();
    }

    function agregarCosa() {
        const modal = new bootstrap.Modal(document.getElementById('agregarCosaModal'));
        modal.show();
    }

    function copiarCodigo(codigo) {
        navigator.clipboard.writeText(codigo).then(function() {
            alert('Código copiado al portapapeles');
        });
    }

    function actualizarCosa(id, comprado) {
        const estado = comprado ? 'comprado' : 'pendiente';
        
        fetch(`/eventos/{{ $evento->id_evento }}/cosas-por-llevar/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ estado: estado })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function compartirEvento() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $evento->titulo }}',
                text: '{{ $evento->descripcion }}',
                url: window.location.href
            });
        } else {
            copiarCodigo(window.location.href);
        }
    }

    function eliminarEvento(id) {
        if (confirm('¿Estás seguro de que quieres eliminar este evento?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/eventos/${id}`;
            
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            
            const tokenField = document.createElement('input');
            tokenField.type = 'hidden';
            tokenField.name = '_token';
            tokenField.value = document.querySelector('meta[name="csrf-token"]').content;
            
            form.appendChild(methodField);
            form.appendChild(tokenField);
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
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

    .btn-outline-secondary {
        color: var(--text-secondary) !important;
        border-color: var(--border-color) !important;
    }

    .btn-outline-secondary:hover {
        color: white !important;
        background-color: var(--text-secondary) !important;
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

    .alert {
        color: var(--text-primary) !important;
    }

    .alert-info {
        background: rgba(79, 172, 254, 0.1) !important;
        border-left: 4px solid #4facfe !important;
        color: #4facfe !important;
    }
</style>
@endsection
