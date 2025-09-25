@extends('layouts.principal')

@section('title', 'Lista de Cosas por Llevar - Eventum')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-4 fw-bold mb-2">
                <span class="gradient-text">Lista de Cosas por Llevar</span>
            </h1>
            <p class="text-muted fs-5">Organiza todo lo que necesitas para tus eventos</p>
        </div>
        <div class="d-flex gap-3">
            <button class="btn btn-outline-primary" onclick="aplicarFiltros()">
                <i class="fas fa-filter me-2"></i>
                Filtrar
            </button>
            <button class="btn btn-primary pulse" data-bs-toggle="modal" data-bs-target="#agregarCosaModal">
                <i class="fas fa-plus me-2"></i>Agregar Elemento
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Buscar elementos..." id="searchInput">
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="estadoFilter">
                        <option value="">Todos los estados</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="comprado">Comprado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="eventoFilter">
                        <option value="">Todos los eventos</option>
                        @foreach(Auth::user()->eventosCreados as $evento)
                            <option value="{{ $evento->id_evento }}">{{ $evento->titulo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-secondary w-100" onclick="limpiarFiltros()">
                        <i class="fas fa-times me-2"></i>
                        Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de elementos -->
    <div id="elementosList">
        @if($cosas->count() > 0)
            <div class="row">
                @foreach($cosas as $cosa)
                    <div class="col-md-6 col-lg-4 mb-4 elemento-card" 
                         data-estado="{{ $cosa->estado }}" 
                         data-evento="{{ $cosa->evento->id_evento }}"
                         data-nombre="{{ strtolower($cosa->nombre) }}">
                        <div class="card list-card h-100 shadow-sm border-0 hover-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-gradient-primary rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-shopping-bag text-white"></i>
                                        </div>
                                        <div>
                                            <h5 class="card-title mb-1">{{ $cosa->nombre }}</h5>
                                            <small class="text-muted">{{ $cosa->evento->titulo }}</small>
                                        </div>
                                    </div>
                                    <span class="badge estado-badge
                                        @if($cosa->estado == 'pendiente') bg-warning
                                        @elseif($cosa->estado == 'comprado') bg-success
                                        @else bg-danger
                                        @endif">
                                        {{ ucfirst($cosa->estado) }}
                                    </span>
                                </div>
                                
                                <div class="elemento-info mb-3">
                                    @if($cosa->cantidad)
                                        <div class="info-item mb-2">
                                            <i class="fas fa-hashtag me-2 text-primary"></i>
                                            <span class="text-muted">Cantidad:</span>
                                            <strong>{{ $cosa->cantidad }}</strong>
                                        </div>
                                    @endif
                                    
                                    @if($cosa->observaciones)
                                        <div class="info-item mb-2">
                                            <i class="fas fa-sticky-note me-2 text-primary"></i>
                                            <span class="text-muted">{{ Str::limit($cosa->observaciones, 50) }}</span>
                                        </div>
                                    @endif
                                    
                                    @if($cosa->usuario)
                                        <div class="info-item mb-2">
                                            <i class="fas fa-user me-2 text-primary"></i>
                                            <span class="text-muted">Asignado a:</span>
                                            <strong>{{ $cosa->usuario->nombre_usuario }}</strong>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $cosa->created_at->format('d M Y') }}
                                    </small>
                                    <div class="btn-group btn-group-sm">
                                        @if($cosa->estado != 'comprado')
                                            <button class="btn btn-outline-success btn-sm" 
                                                    onclick="actualizarEstado({{ $cosa->id_cosa }}, 'comprado')"
                                                    title="Marcar como comprado">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        @if($cosa->estado != 'cancelado')
                                            <button class="btn btn-outline-warning btn-sm" 
                                                    onclick="actualizarEstado({{ $cosa->id_cosa }}, 'cancelado')"
                                                    title="Cancelar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        @endif
                                        @if($cosa->estado != 'pendiente')
                                            <button class="btn btn-outline-info btn-sm" 
                                                    onclick="actualizarEstado({{ $cosa->id_cosa }}, 'pendiente')"
                                                    title="Marcar como pendiente">
                                                <i class="fas fa-clock"></i>
                                            </button>
                                        @endif
                                        <button class="btn btn-outline-danger btn-sm" 
                                                onclick="eliminarCosa({{ $cosa->id_cosa }})"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $cosas->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="bg-gradient-primary rounded-circle mx-auto mb-4" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shopping-bag text-white" style="font-size: 3rem;"></i>
                </div>
                <h3 class="text-muted mb-3">No hay elementos en la lista</h3>
                <p class="text-muted mb-4">¡Agrega algo para llevar a tus eventos!</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarCosaModal">
                    <i class="fas fa-plus me-2"></i>Agregar Primer Elemento
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal para agregar cosa -->
<div class="modal fade" id="agregarCosaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Elemento a la Lista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('lista.crear') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_evento" class="form-label">Evento</label>
                        <select class="form-control" id="id_evento" name="id_evento" required>
                            <option value="">Selecciona un evento</option>
                            @foreach(Auth::user()->eventosCreados as $evento)
                                <option value="{{ $evento->id_evento }}">{{ $evento->titulo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Elemento</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" 
                               placeholder="Ej: Refrescos, Decoraciones, etc." required>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad (opcional)</label>
                        <input type="text" class="form-control" id="cantidad" name="cantidad" 
                               placeholder="Ej: 2 botellas, 10 globos, etc.">
                    </div>
                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones (opcional)</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="3" 
                                  placeholder="Detalles adicionales..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Agregar a la Lista</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function aplicarFiltros() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const estadoFilter = document.getElementById('estadoFilter').value;
        const eventoFilter = document.getElementById('eventoFilter').value;
        const cards = document.querySelectorAll('.elemento-card');

        cards.forEach(card => {
            const nombre = card.dataset.nombre;
            const estado = card.dataset.estado;
            const evento = card.dataset.evento;
            
            let show = true;

            // Filtro de búsqueda
            if (searchTerm && !nombre.includes(searchTerm)) {
                show = false;
            }

            // Filtro de estado
            if (estadoFilter && estado !== estadoFilter) {
                show = false;
            }

            // Filtro de evento
            if (eventoFilter && evento !== eventoFilter) {
                show = false;
            }

            if (show) {
                card.classList.remove('hidden');
                card.style.display = 'block';
            } else {
                card.classList.add('hidden');
                card.style.display = 'none';
            }
        });
    }

    function limpiarFiltros() {
        document.getElementById('searchInput').value = '';
        document.getElementById('estadoFilter').value = '';
        document.getElementById('eventoFilter').value = '';
        aplicarFiltros();
    }

    function actualizarEstado(id, estado) {
        if (confirm('¿Estás seguro de cambiar el estado de este elemento?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/lista/${id}/actualizar`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            const estadoInput = document.createElement('input');
            estadoInput.type = 'hidden';
            estadoInput.name = 'estado';
            estadoInput.value = estado;
            
            form.appendChild(csrfToken);
            form.appendChild(estadoInput);
            document.body.appendChild(form);
            form.submit();
        }
    }

    function eliminarCosa(id) {
        if (confirm('¿Estás seguro de eliminar este elemento de la lista?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/lista/${id}/eliminar`;
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Aplicar filtros en tiempo real
    document.getElementById('searchInput').addEventListener('input', aplicarFiltros);
    document.getElementById('estadoFilter').addEventListener('change', aplicarFiltros);
    document.getElementById('eventoFilter').addEventListener('change', aplicarFiltros);

    // Animaciones de entrada
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.elemento-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });
</script>
@endsection

@section('styles')
<style>
    /* Estilos generales */
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

    .btn-outline-success {
        color: var(--success-color) !important;
        border-color: var(--success-color) !important;
    }

    .btn-outline-success:hover {
        color: white !important;
        background-color: var(--success-color) !important;
    }

    .btn-outline-warning {
        color: var(--warning-color) !important;
        border-color: var(--warning-color) !important;
    }

    .btn-outline-warning:hover {
        color: white !important;
        background-color: var(--warning-color) !important;
    }

    .btn-outline-info {
        color: var(--info-color) !important;
        border-color: var(--info-color) !important;
    }

    .btn-outline-info:hover {
        color: white !important;
        background-color: var(--info-color) !important;
    }

    .btn-outline-danger {
        color: var(--danger-color) !important;
        border-color: var(--danger-color) !important;
    }

    .btn-outline-danger:hover {
        color: white !important;
        background-color: var(--danger-color) !important;
    }

    .btn-outline-secondary {
        color: var(--text-muted) !important;
        border-color: var(--text-muted) !important;
    }

    .btn-outline-secondary:hover {
        color: white !important;
        background-color: var(--text-muted) !important;
    }

    /* Tarjetas de lista */
    .list-card {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 12px !important;
        transition: all 0.3s ease;
    }

    .list-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px var(--shadow);
        border-color: var(--primary-color) !important;
    }

    .list-card .card-title {
        color: var(--text-primary) !important;
        font-weight: 600;
    }

    .list-card .card-text {
        color: var(--text-secondary) !important;
    }

    /* Información de elementos */
    .elemento-info {
        background: var(--bg-tertiary);
        border-radius: 8px;
        padding: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
    }

    .info-item i {
        width: 16px;
        text-align: center;
    }

    /* Badges de estado */
    .estado-badge {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
    }

    .bg-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
    }

    .bg-success {
        background: linear-gradient(135deg, #10b981, #059669) !important;
    }

    .bg-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
    }

    /* Filtros */
    .form-control {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
    }

    .form-control:focus {
        background: var(--bg-secondary) !important;
        border-color: var(--primary-color) !important;
        color: var(--text-primary) !important;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-control::placeholder {
        color: var(--text-muted) !important;
    }

    /* Modal */
    .modal-content {
        background: var(--bg-secondary) !important;
        color: var(--text-primary) !important;
        border-radius: 12px !important;
    }

    .modal-header {
        border-bottom: 1px solid var(--border-color) !important;
    }

    .modal-footer {
        border-top: 1px solid var(--border-color) !important;
    }

    .modal-title {
        color: var(--text-primary) !important;
    }

    .form-label {
        color: var(--text-primary) !important;
        font-weight: 600;
    }

    /* Animaciones */
    .elemento-card {
        animation: slideInUp 0.5s ease-out;
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Estados de filtrado */
    .elemento-card.hidden {
        display: none !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .list-card .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .elemento-info {
            padding: 0.75rem;
        }
        
        .btn-group .btn {
            padding: 0.375rem 0.5rem;
            font-size: 0.8rem;
        }
    }
</style>
@endsection
