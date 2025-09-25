@extends('layouts.principal')

@section('title', 'Mis Eventos - Eventum')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-4 fw-bold mb-2">
                <span class="gradient-text">
                    Mis Eventos
                </span>
            </h1>
            <p class="text-muted fs-5">Gestiona todos tus eventos de manera inteligente</p>
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

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Buscar eventos..." id="searchInput">
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="statusFilter">
                        <option value="">Todos los estados</option>
                        <option value="proximos">Próximos</option>
                        <option value="pasados">Pasados</option>
                        <option value="hoy">Hoy</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="tipoFilter">
                        <option value="">Todos los tipos</option>
                        <option value="fijo">Presupuesto Fijo</option>
                        <option value="sugerido">Presupuesto Sugerido</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-primary w-100" onclick="aplicarFiltros()">
                        <i class="fas fa-filter me-2"></i>
                        Filtrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de eventos -->
    <div class="row" id="eventosGrid">
        @forelse($eventos as $evento)
            <div class="col-lg-4 col-md-6 mb-4 evento-card" data-fecha="{{ $evento->fecha_inicio }}" data-tipo="{{ $evento->tipoPresupuesto->nombre_tipo }}">
                <div class="card h-100 hover-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-gradient-primary rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-calendar text-white"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">{{ Str::limit($evento->titulo, 30) }}</h6>
                                <small class="text-muted">{{ $evento->tipoPresupuesto->nombre_tipo }}</small>
                                @if($evento->id_anfitrion == Auth::id())
                                    <span class="badge bg-primary ms-2">Anfitrión</span>
                                @else
                                    <span class="badge bg-success ms-2">Participante</span>
                                @endif
                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('eventos.show', $evento->id_evento) }}">Ver detalles</a></li>
                                @if($evento->id_anfitrion == Auth::id())
                                    <li><a class="dropdown-item" href="{{ route('eventos.edit', $evento->id_evento) }}">Editar</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="eliminarEvento({{ $evento->id_evento }})">Eliminar</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <p class="text-muted mb-3">{{ Str::limit($evento->descripcion, 100) }}</p>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">Fecha</small>
                                <strong>{{ $evento->fecha_inicio->format('d M Y') }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Hora</small>
                                <strong>{{ $evento->hora_inicio ?? 'Sin hora' }}</strong>
                            </div>
                        </div>

                        @if($evento->lugar)
                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    Lugar
                                </small>
                                <strong>{{ Str::limit($evento->lugar, 40) }}</strong>
                            </div>
                        @endif

                        @if($evento->presupuesto)
                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    <i class="fas fa-dollar-sign me-1"></i>
                                    Presupuesto
                                </small>
                                <strong>${{ number_format($evento->presupuesto, 2) }}</strong>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">Participantes</small>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users me-1 text-primary"></i>
                                    <span class="fw-bold">{{ $evento->participantes->count() }}</span>
                                </div>
                            </div>
                            <div>
                                <small class="text-muted">Código de Invitación</small>
                                <div class="d-flex align-items-center">
                                    <div class="code-container">
                                        <code class="event-code bg-light px-2 py-1 rounded" style="display: none;">{{ $evento->codigo_evento }}</code>
                                        <span class="code-placeholder text-muted">••••••••</span>
                                    </div>
                                    <div class="btn-group ms-2" role="group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="toggleCode(this)" title="Mostrar/Ocultar código">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary" onclick="copiarCodigo('{{ $evento->codigo_evento }}')" title="Copiar código">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn btn-primary btn-sm flex-grow-1">
                                <i class="fas fa-eye me-1"></i>
                                Ver Detalles
                            </a>
                            <a href="{{ route('eventos.edit', $evento->id_evento) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="bg-gradient-primary rounded-circle mx-auto mb-4" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-calendar-plus text-white" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="text-muted mb-3">No tienes eventos creados</h3>
                    <p class="text-muted mb-4">¡Crea tu primer evento para comenzar a gestionar tus actividades!</p>
                    <a href="{{ route('eventos.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        Crear Mi Primer Evento
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($eventos->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $eventos->links() }}
        </div>
    @endif
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
    /* Tarjetas de eventos mejoradas */
    .hover-card {
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 16px !important;
        overflow: hidden;
        position: relative;
    }

    .hover-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .evento-card {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.2);
        padding: 1.25rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-footer {
        background: rgba(255, 255, 255, 0.02);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1rem 1.5rem;
    }

    /* Contenedor de código */
    .code-container {
        position: relative;
        min-width: 120px;
    }

    .event-code {
        font-family: 'Courier New', monospace;
        font-weight: bold;
        letter-spacing: 1px;
        background: var(--bg-tertiary) !important;
        color: var(--text-primary) !important;
        border: 1px solid var(--border-color) !important;
    }

    .code-placeholder {
        font-family: 'Courier New', monospace;
        letter-spacing: 2px;
        font-size: 0.9rem;
    }

    /* Botones de código */
    .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 1px;
    }

    .btn-group .btn:first-child {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }

    .btn-group .btn:last-child {
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    /* Iconos de estado */
    .status-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-proximo {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .status-pasado {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
    }

    .status-hoy {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    /* Mejoras visuales */
    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .card-subtitle {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 0;
    }

    .event-info {
        background: var(--bg-tertiary);
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 1rem;
    }

    .event-info .row > div {
        margin-bottom: 0.5rem;
    }

    .event-info .row > div:last-child {
        margin-bottom: 0;
    }

    /* Animaciones de hover */
    .hover-card:hover .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
    }

    .hover-card:hover .event-code {
        background: var(--primary-color) !important;
        color: white !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-header {
            padding: 1rem;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .card-footer {
            padding: 0.75rem 1rem;
        }
        
        .code-container {
            min-width: 100px;
        }
        
        .btn-group .btn {
            padding: 0.375rem 0.5rem;
            font-size: 0.8rem;
        }
    }
</style>

<script>
    function abrirUnirseEvento() {
        const modal = new bootstrap.Modal(document.getElementById('unirseEventoModal'));
        modal.show();
    }

    function toggleCode(button) {
        const container = button.closest('.d-flex').querySelector('.code-container');
        const code = container.querySelector('.event-code');
        const placeholder = container.querySelector('.code-placeholder');
        const icon = button.querySelector('i');
        
        if (code.style.display === 'none') {
            // Mostrar código
            code.style.display = 'inline-block';
            placeholder.style.display = 'none';
            icon.className = 'fas fa-eye-slash';
            button.title = 'Ocultar código';
        } else {
            // Ocultar código
            code.style.display = 'none';
            placeholder.style.display = 'inline-block';
            icon.className = 'fas fa-eye';
            button.title = 'Mostrar código';
        }
    }

    function copiarCodigo(codigo) {
        navigator.clipboard.writeText(codigo).then(function() {
            mostrarNotificacion('Código copiado al portapapeles', 'success');
        }).catch(function() {
            // Fallback para navegadores que no soportan clipboard API
            const textArea = document.createElement('textarea');
            textArea.value = codigo;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            mostrarNotificacion('Código copiado al portapapeles', 'success');
        });
    }

    function mostrarNotificacion(mensaje, tipo) {
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.innerHTML = `<i class="fas fa-${tipo === 'success' ? 'check' : 'exclamation-triangle'} me-2"></i>${mensaje}`;
        toast.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${tipo === 'success' ? 'var(--success-color)' : 'var(--danger-color)'};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 9999;
            animation: slideInRight 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        `;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
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

    function aplicarFiltros() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const tipoFilter = document.getElementById('tipoFilter').value;
        const cards = document.querySelectorAll('.evento-card');

        cards.forEach(card => {
            const titulo = card.querySelector('h6').textContent.toLowerCase();
            const descripcion = card.querySelector('p').textContent.toLowerCase();
            const fecha = new Date(card.dataset.fecha);
            const tipo = card.dataset.tipo;
            
            let show = true;

            // Filtro de búsqueda
            if (searchTerm && !titulo.includes(searchTerm) && !descripcion.includes(searchTerm)) {
                show = false;
            }

            // Filtro de estado
            if (statusFilter) {
                const hoy = new Date();
                hoy.setHours(0, 0, 0, 0);
                
                if (statusFilter === 'proximos' && fecha < hoy) {
                    show = false;
                } else if (statusFilter === 'pasados' && fecha >= hoy) {
                    show = false;
                } else if (statusFilter === 'hoy') {
                    const hoyStr = hoy.toISOString().split('T')[0];
                    const fechaStr = fecha.toISOString().split('T')[0];
                    if (fechaStr !== hoyStr) {
                        show = false;
                    }
                }
            }

            // Filtro de tipo
            if (tipoFilter && tipo !== tipoFilter) {
                show = false;
            }

            card.style.display = show ? 'block' : 'none';
        });
    }

    // Aplicar filtros en tiempo real
    document.getElementById('searchInput').addEventListener('input', aplicarFiltros);
    document.getElementById('statusFilter').addEventListener('change', aplicarFiltros);
    document.getElementById('tipoFilter').addEventListener('change', aplicarFiltros);

    // Animaciones de entrada
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.evento-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });

    // CSS para animaciones de notificaciones
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
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
