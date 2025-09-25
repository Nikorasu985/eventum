@extends('layouts.principal')

@section('title', 'Notificaciones - Eventum')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-4 fw-bold mb-2">
                <span class="gradient-text">Notificaciones</span>
            </h1>
            <p class="text-muted fs-5">Mantente al día con todas las actividades</p>
        </div>
        <div class="d-flex gap-3">
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-cog me-2"></i>
                    Opciones
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <form action="{{ route('notificaciones.marcar-todas-leidas') }}" method="POST" class="d-inline w-100">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-check-double me-2"></i>
                                Marcar Todas como Leídas
                            </button>
                        </form>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="marcarTodasNoLeidas()">
                            <i class="fas fa-eye me-2"></i>
                            Marcar Todas como No Leídas
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="eliminarTodasLeidas()">
                            <i class="fas fa-trash me-2"></i>
                            Eliminar Leídas
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="#" onclick="exportarNotificaciones()">
                            <i class="fas fa-download me-2"></i>
                            Exportar Notificaciones
                        </a>
                    </li>
                </ul>
            </div>
            <button class="btn btn-primary pulse" onclick="abrirConfiguracionNotificaciones()">
                <i class="fas fa-bell-slash me-2"></i>
                Configurar
            </button>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Buscar notificaciones..." id="searchInput">
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="statusFilter">
                        <option value="">Todas las notificaciones</option>
                        <option value="no-leidas">No leídas</option>
                        <option value="leidas">Leídas</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-control" id="tipoFilter">
                        <option value="">Todos los tipos</option>
                        <option value="invitacion">Invitación</option>
                        <option value="evento">Evento</option>
                        <option value="sistema">Sistema</option>
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

    <!-- Lista de notificaciones -->
    <div id="notificacionesList">
        @forelse($notificaciones as $notificacion)
            <div class="notification-card mb-3 {{ !$notificacion->leida ? 'notification-unread' : 'notification-read' }}" 
                 data-leida="{{ $notificacion->leida ? 'true' : 'false' }}" 
                 data-tipo="{{ $notificacion->tipoNotificacion->nombre_tipo ?? 'sistema' }}">
                <div class="card-body">
                    <div class="d-flex align-items-start">
                        <div class="notification-icon me-3">
                            <div class="bg-gradient-primary rounded-circle d-flex align-items-center justify-content-center">
                                @if($notificacion->tipoNotificacion)
                                    @switch($notificacion->tipoNotificacion->nombre_tipo)
                                        @case('Invitación')
                                            <i class="fas fa-envelope text-white"></i>
                                            @break
                                        @case('Evento')
                                            <i class="fas fa-calendar text-white"></i>
                                            @break
                                        @case('Sistema')
                                            <i class="fas fa-cog text-white"></i>
                                            @break
                                        @default
                                            <i class="fas fa-bell text-white"></i>
                                    @endswitch
                                @else
                                    <i class="fas fa-bell text-white"></i>
                                @endif
                            </div>
                            @if(!$notificacion->leida)
                                <div class="notification-dot"></div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0 notification-title">{{ $notificacion->tipoNotificacion->nombre_tipo ?? 'Notificación' }}</h6>
                                <div class="d-flex align-items-center gap-2">
                                    <small class="text-muted">{{ $notificacion->fecha_envio->diffForHumans() }}</small>
                                    @if(!$notificacion->leida)
                                        <form action="{{ route('notificaciones.marcar-leida', $notificacion->id_notificacion) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary notification-mark-btn">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <p class="notification-content mb-2">{{ $notificacion->contenido }}</p>
                            @if($notificacion->evento)
                                <div class="notification-event-info">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        Evento: {{ $notificacion->evento->titulo }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <div class="bg-gradient-primary rounded-circle mx-auto mb-4" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-bell-slash text-white" style="font-size: 3rem;"></i>
                </div>
                <h3 class="text-muted mb-3">No hay notificaciones</h3>
                <p class="text-muted mb-4">Cuando tengas notificaciones, aparecerán aquí</p>
            </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if($notificaciones->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $notificaciones->links() }}
        </div>
    @endif
</div>
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

    /* Tarjetas de notificaciones */
    .notification-card {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 12px !important;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .notification-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px var(--shadow);
        border-color: var(--primary-color) !important;
    }

    .notification-unread {
        border-left: 4px solid var(--primary-color) !important;
        background: linear-gradient(135deg, var(--bg-secondary) 0%, rgba(102, 126, 234, 0.05) 100%) !important;
    }

    .notification-read {
        opacity: 0.8;
    }

    .notification-read:hover {
        opacity: 1;
    }

    /* Icono de notificación */
    .notification-icon {
        position: relative;
        width: 40px;
        height: 40px;
    }

    .notification-icon .bg-gradient-primary {
        width: 40px;
        height: 40px;
        font-size: 16px;
    }

    .notification-dot {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 12px;
        height: 12px;
        background: var(--danger-color);
        border-radius: 50%;
        border: 2px solid var(--bg-secondary);
        animation: pulse-dot 2s infinite;
    }

    @keyframes pulse-dot {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.7;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Contenido de notificación */
    .notification-title {
        color: var(--text-primary) !important;
        font-weight: 600;
        font-size: 1rem;
    }

    .notification-content {
        color: var(--text-secondary) !important;
        line-height: 1.5;
        margin-bottom: 0.5rem;
    }

    .notification-event-info {
        background: var(--bg-tertiary);
        padding: 0.5rem;
        border-radius: 6px;
        border-left: 3px solid var(--accent-color);
    }

    .notification-event-info small {
        color: var(--text-muted) !important;
        font-size: 0.85rem;
    }

    /* Botón de marcar como leída */
    .notification-mark-btn {
        transition: all 0.3s ease;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .notification-mark-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
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

    /* Animaciones */
    .notification-card {
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

    /* Responsive */
    @media (max-width: 768px) {
        .notification-card .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }
        
        .notification-icon {
            margin-bottom: 1rem;
        }
        
        .notification-mark-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }
    }

    /* Estados de filtrado */
    .notification-card.hidden {
        display: none !important;
    }

    /* Paginación */
    .pagination .page-link {
        background: var(--bg-secondary) !important;
        border-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }

    .pagination .page-link:hover {
        background: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        color: white !important;
    }

    .pagination .page-item.active .page-link {
        background: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }
</style>
@endsection

@section('scripts')
<script>
    function aplicarFiltros() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const tipoFilter = document.getElementById('tipoFilter').value;
        const cards = document.querySelectorAll('.notification-card');

        cards.forEach(card => {
            const content = card.querySelector('.notification-content').textContent.toLowerCase();
            const title = card.querySelector('.notification-title').textContent.toLowerCase();
            const leida = card.dataset.leida === 'true';
            const tipo = card.dataset.tipo.toLowerCase();
            
            let show = true;

            // Filtro de búsqueda
            if (searchTerm && !content.includes(searchTerm) && !title.includes(searchTerm)) {
                show = false;
            }

            // Filtro de estado
            if (statusFilter) {
                if (statusFilter === 'no-leidas' && leida) {
                    show = false;
                } else if (statusFilter === 'leidas' && !leida) {
                    show = false;
                }
            }

            // Filtro de tipo
            if (tipoFilter) {
                if (!tipo.includes(tipoFilter)) {
                    show = false;
                }
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

    // Aplicar filtros en tiempo real
    document.getElementById('searchInput').addEventListener('input', aplicarFiltros);
    document.getElementById('statusFilter').addEventListener('change', aplicarFiltros);
    document.getElementById('tipoFilter').addEventListener('change', aplicarFiltros);

    // Animaciones de entrada
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.notification-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    });

    // Marcar notificación como leída con AJAX
    document.addEventListener('DOMContentLoaded', function() {
        const markButtons = document.querySelectorAll('.notification-mark-btn');
        markButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const form = this.closest('form');
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const card = this.closest('.notification-card');
                        card.classList.remove('notification-unread');
                        card.classList.add('notification-read');
                        card.dataset.leida = 'true';
                        
                        // Remover el botón y el dot
                        this.remove();
                        const dot = card.querySelector('.notification-dot');
                        if (dot) dot.remove();
                        
                        // Mostrar notificación de éxito
                        mostrarNotificacion('Notificación marcada como leída', 'success');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    mostrarNotificacion('Error al marcar la notificación', 'error');
                });
            });
        });
    });

    function marcarTodasNoLeidas() {
        if (confirm('¿Estás seguro de marcar todas las notificaciones como no leídas?')) {
            const cards = document.querySelectorAll('.notification-card');
            cards.forEach(card => {
                card.classList.remove('notification-read');
                card.classList.add('notification-unread');
                card.dataset.leida = 'false';
                
                // Agregar botón de marcar como leída si no existe
                if (!card.querySelector('.notification-mark-btn')) {
                    const buttonContainer = card.querySelector('.d-flex.align-items-center.gap-2');
                    const form = document.createElement('form');
                    form.action = card.querySelector('form')?.action || '#';
                    form.method = 'POST';
                    form.className = 'd-inline';
                    
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
                    
                    const button = document.createElement('button');
                    button.type = 'submit';
                    button.className = 'btn btn-sm btn-outline-primary notification-mark-btn';
                    button.innerHTML = '<i class="fas fa-check"></i>';
                    
                    form.appendChild(csrfToken);
                    form.appendChild(button);
                    buttonContainer.appendChild(form);
                }
                
                // Agregar dot de notificación no leída
                if (!card.querySelector('.notification-dot')) {
                    const iconContainer = card.querySelector('.notification-icon');
                    const dot = document.createElement('div');
                    dot.className = 'notification-dot';
                    iconContainer.appendChild(dot);
                }
            });
            mostrarNotificacion('Todas las notificaciones marcadas como no leídas', 'success');
        }
    }

    function eliminarTodasLeidas() {
        if (confirm('¿Estás seguro de eliminar todas las notificaciones leídas?')) {
            const cards = document.querySelectorAll('.notification-card.notification-read');
            cards.forEach(card => {
                card.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => card.remove(), 300);
            });
            mostrarNotificacion('Notificaciones leídas eliminadas', 'success');
        }
    }

    function exportarNotificaciones() {
        const cards = document.querySelectorAll('.notification-card');
        let csvContent = "Tipo,Contenido,Fecha,Estado\n";
        
        cards.forEach(card => {
            const tipo = card.querySelector('.notification-title').textContent;
            const contenido = card.querySelector('.notification-content').textContent;
            const fecha = card.querySelector('small').textContent;
            const estado = card.classList.contains('notification-read') ? 'Leída' : 'No leída';
            
            csvContent += `"${tipo}","${contenido}","${fecha}","${estado}"\n`;
        });
        
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'notificaciones.csv';
        a.click();
        window.URL.revokeObjectURL(url);
        
        mostrarNotificacion('Notificaciones exportadas exitosamente', 'success');
    }

    function abrirConfiguracionNotificaciones() {
        // Crear modal de configuración
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.id = 'configNotificacionesModal';
        modal.innerHTML = `
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Configuración de Notificaciones</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Frecuencia de notificaciones</label>
                            <select class="form-control" id="frecuenciaNotificaciones">
                                <option value="inmediata">Inmediata</option>
                                <option value="diaria">Diaria</option>
                                <option value="semanal">Semanal</option>
                                <option value="nunca">Nunca</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notificacionesEmail" checked>
                                <label class="form-check-label" for="notificacionesEmail">
                                    Recibir notificaciones por email
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notificacionesPush" checked>
                                <label class="form-check-label" for="notificacionesPush">
                                    Recibir notificaciones push
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notificacionesEventos" checked>
                                <label class="form-check-label" for="notificacionesEventos">
                                    Notificaciones de eventos
                                </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notificacionesInvitaciones" checked>
                                <label class="form-check-label" for="notificacionesInvitaciones">
                                    Notificaciones de invitaciones
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="guardarConfiguracionNotificaciones()">Guardar</button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        
        modal.addEventListener('hidden.bs.modal', () => {
            modal.remove();
        });
    }

    function guardarConfiguracionNotificaciones() {
        const config = {
            frecuencia: document.getElementById('frecuenciaNotificaciones').value,
            email: document.getElementById('notificacionesEmail').checked,
            push: document.getElementById('notificacionesPush').checked,
            eventos: document.getElementById('notificacionesEventos').checked,
            invitaciones: document.getElementById('notificacionesInvitaciones').checked
        };
        
        // Guardar en localStorage
        localStorage.setItem('configuracionNotificaciones', JSON.stringify(config));
        
        // Cerrar modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('configNotificacionesModal'));
        modal.hide();
        
        mostrarNotificacion('Configuración de notificaciones guardada', 'success');
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
