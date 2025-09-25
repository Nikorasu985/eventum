@extends('layouts.principal')

@section('title', 'Configuración - Eventum')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-4 fw-bold mb-2">
                <span class="gradient-text">
                    Configuración
                </span>
            </h1>
            <p class="text-muted fs-5">Personaliza tu experiencia en Eventum</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('configuracion.actualizar') }}" method="POST" id="configForm">
                @csrf
                @method('PUT')

                <!-- Apariencia -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-palette me-2 text-primary"></i>
                            Apariencia
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tema</label>
                                <select class="form-control" name="tema" id="temaSelect">
                                    <option value="minimalista" {{ ($configuracion->tema ?? 'minimalista') == 'minimalista' ? 'selected' : '' }}>Minimalista</option>
                                    <option value="neon" {{ ($configuracion->tema ?? 'minimalista') == 'neon' ? 'selected' : '' }}>Neon</option>
                                    <option value="cyber" {{ ($configuracion->tema ?? 'minimalista') == 'cyber' ? 'selected' : '' }}>Cyber</option>
                                    <option value="monocromatico" {{ ($configuracion->tema ?? 'minimalista') == 'monocromatico' ? 'selected' : '' }}>Monocromático</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Modo Oscuro</label>
                                <select class="form-control" name="modo_oscuro" id="modoOscuroSelect">
                                    <option value="auto" {{ $configuracion->modo_oscuro == 'auto' ? 'selected' : '' }}>Automático</option>
                                    <option value="dark" {{ $configuracion->modo_oscuro == 'dark' ? 'selected' : '' }}>Oscuro</option>
                                    <option value="light" {{ $configuracion->modo_oscuro == 'light' ? 'selected' : '' }}>Claro</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-6">
                                <label class="form-label">Tamaño de Fuente</label>
                                <input type="range" class="form-range" name="tamaño_fuente" min="12" max="24" value="{{ $configuracion->tamaño_fuente ?? 16 }}" id="fontSizeSlider">
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">12px</small>
                                    <small class="text-muted" id="fontSizeValue">16px</small>
                                    <small class="text-muted">24px</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tipo de Fuente</label>
                                <select class="form-control" name="tipo_fuente">
                                    <option value="Inter" {{ ($configuracion->tipo_fuente ?? 'Inter') == 'Inter' ? 'selected' : '' }}>Inter</option>
                                    <option value="Space Grotesk" {{ ($configuracion->tipo_fuente ?? 'Inter') == 'Space Grotesk' ? 'selected' : '' }}>Space Grotesk</option>
                                    <option value="Roboto" {{ ($configuracion->tipo_fuente ?? 'Inter') == 'Roboto' ? 'selected' : '' }}>Roboto</option>
                                    <option value="Open Sans" {{ ($configuracion->tipo_fuente ?? 'Inter') == 'Open Sans' ? 'selected' : '' }}>Open Sans</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="animaciones_habilitadas" id="animacionesSwitch" {{ ($configuracion->animaciones_habilitadas ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="animacionesSwitch">
                                    Habilitar animaciones
                                </label>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Botones -->
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>
                        Guardar Configuración
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-lg" onclick="resetearConfiguracion()">
                        <i class="fas fa-undo me-2"></i>
                        Restaurar Predeterminados
                    </button>
                </div>
            </form>
        </div>

        <!-- Panel lateral con vista previa -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-eye me-2 text-primary"></i>
                        Vista Previa
                    </h6>
                </div>
                <div class="card-body">
                    <div id="previewCard" class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Ejemplo de Evento</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">Este es un ejemplo de cómo se verá tu interfaz con la configuración actual.</p>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">Etiqueta</span>
                                <span class="badge bg-secondary">Ejemplo</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h6 class="text-muted">Configuración Actual:</h6>
                        <ul class="list-unstyled small">
                            <li><strong>Tema:</strong> <span id="currentTheme">Minimalista</span></li>
                            <li><strong>Modo:</strong> <span id="currentMode">Oscuro</span></li>
                            <li><strong>Fuente:</strong> <span id="currentFont">16px Inter</span></li>
                        </ul>
                    </div>

                    <!-- Acciones Rápidas -->
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">Acciones Rápidas:</h6>
                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="aplicarCambios()">
                                <i class="fas fa-save me-2"></i>
                                Aplicar Cambios
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm" onclick="resetearVistaPrevia()">
                                <i class="fas fa-refresh me-2"></i>
                                Resetear Vista Previa
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .theme-preview {
        cursor: pointer;
        padding: 10px;
        border: 2px solid transparent;
        border-radius: 8px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .theme-preview:hover {
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }

    .theme-preview.active {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .theme-colors {
        display: flex;
        gap: 2px;
        margin-bottom: 5px;
    }

    .theme-colors .color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
    }

    .form-range::-webkit-slider-thumb {
        background: var(--primary-gradient);
    }

    .form-range::-moz-range-thumb {
        background: var(--primary-gradient);
    }

    .sticky-top {
        position: sticky;
        top: 20px;
    }

    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    // Actualizar vista previa en tiempo real
    function actualizarVistaPrevia() {
        const tema = document.getElementById('temaSelect').value;
        const modo = document.getElementById('modoOscuroSelect').value;
        const fontSize = document.getElementById('fontSizeSlider').value;
        const fontFamily = document.querySelector('select[name="tipo_fuente"]').value;

        // Actualizar información actual
        document.getElementById('currentTheme').textContent = tema.charAt(0).toUpperCase() + tema.slice(1);
        document.getElementById('currentMode').textContent = modo.charAt(0).toUpperCase() + modo.slice(1);
        document.getElementById('currentFont').textContent = fontSize + 'px ' + fontFamily;

        // Aplicar cambios a la vista previa
        const previewCard = document.getElementById('previewCard');
        previewCard.style.fontSize = fontSize + 'px';
        previewCard.style.fontFamily = fontFamily;
    }

    // Cambiar tema
    function cambiarTema(tema) {
        document.getElementById('temaSelect').value = tema;
        document.querySelectorAll('.theme-preview').forEach(el => el.classList.remove('active'));
        document.querySelector(`[data-theme="${tema}"]`).classList.add('active');
        actualizarVistaPrevia();
    }

    // Resetear configuración
    function resetearConfiguracion() {
        if (confirm('¿Estás seguro de que quieres restaurar la configuración predeterminada?')) {
            document.getElementById('temaSelect').value = 'futurista';
            document.getElementById('modoOscuroSelect').value = 'dark';
            document.getElementById('fontSizeSlider').value = 16;
            document.querySelector('select[name="tipo_fuente"]').value = 'Inter';
            document.querySelector('select[name="idioma"]').value = 'es';
            document.querySelector('select[name="zona_horaria"]').value = 'America/Mexico_City';
            
            actualizarVistaPrevia();
        }
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Actualizar valor del slider de fuente
        const fontSizeSlider = document.getElementById('fontSizeSlider');
        const fontSizeValue = document.getElementById('fontSizeValue');
        
        fontSizeSlider.addEventListener('input', function() {
            fontSizeValue.textContent = this.value + 'px';
            actualizarVistaPrevia();
        });

        // Event listeners para actualizar vista previa
        document.getElementById('temaSelect').addEventListener('change', actualizarVistaPrevia);
        document.getElementById('modoOscuroSelect').addEventListener('change', actualizarVistaPrevia);
        document.querySelector('select[name="tipo_fuente"]').addEventListener('change', actualizarVistaPrevia);

        // Color preview function
        function updateColorPreview(colorType, colorValue) {
            const colorMap = {
                'primary': '--primary-color',
                'secondary': '--secondary-color',
                'accent': '--accent-color'
            };
            
            if (colorMap[colorType]) {
                document.documentElement.style.setProperty(colorMap[colorType], colorValue);
            }
        }

        // Detectar zona horaria automáticamente
        function detectarZonaHoraria() {
            const zonaHoraria = Intl.DateTimeFormat().resolvedOptions().timeZone;
            const select = document.getElementById('zonaHorariaSelect');
            
            // Buscar si la zona horaria detectada está en las opciones
            for (let option of select.options) {
                if (option.value === zonaHoraria) {
                    option.selected = true;
                    break;
                }
            }
        }

        // Restaurar configuración predeterminada
        function restaurarPredeterminados() {
            if (confirm('¿Estás seguro de que quieres restaurar la configuración predeterminada?')) {
                // Restaurar valores predeterminados
                document.getElementById('temaSelect').value = 'minimalista';
                document.getElementById('modoOscuroSelect').value = 'dark';
                document.getElementById('idiomaSelect').value = 'es';
                document.getElementById('zonaHorariaSelect').value = 'auto';
                document.getElementById('tamañoFuente').value = 16;
                document.getElementById('tipoFuente').value = 'Inter';
                document.getElementById('animacionesHabilitadas').checked = true;
                
                // Aplicar cambios inmediatamente
                aplicarCambios();
                
                // Mostrar mensaje de éxito
                mostrarMensaje('Configuración restaurada a valores predeterminados', 'success');
            }
        }

        // Aplicar cambios de configuración
        function aplicarCambios() {
            const form = document.getElementById('configForm');
            const formData = new FormData(form);
            
            // Mostrar loading
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Aplicando...';
            submitBtn.disabled = true;
            
            fetch('/configuracion/actualizar', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje('Configuración actualizada exitosamente', 'success');
                    actualizarVistaPrevia();
                } else {
                    mostrarMensaje('Error al actualizar la configuración', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensaje('Error al actualizar la configuración', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }

        // Resetear vista previa
        function resetearVistaPrevia() {
            actualizarVistaPrevia();
            mostrarMensaje('Vista previa actualizada', 'info');
        }

        // Mostrar mensaje de notificación
        function mostrarMensaje(mensaje, tipo) {
            const alertClass = tipo === 'success' ? 'alert-success' : tipo === 'error' ? 'alert-danger' : 'alert-info';
            const alert = document.createElement('div');
            alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
            alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
            alert.innerHTML = `
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(alert);
            
            // Auto-remove after 3 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.parentNode.removeChild(alert);
                }
            }, 3000);
        }

        // Marcar tema actual como activo
        const currentTheme = document.getElementById('temaSelect').value;
        document.querySelector(`[data-theme="${currentTheme}"]`).classList.add('active');

        // Inicializar vista previa
        actualizarVistaPrevia();
        
        // Detectar zona horaria al cargar
        detectarZonaHoraria();

        // Guardar configuración automáticamente
        const form = document.getElementById('configForm');
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Mostrar loading
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
            submitBtn.disabled = true;

            // Simular guardado
            setTimeout(() => {
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Guardado';
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 2000);
            }, 1000);
        });
    });
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

    .form-label {
        color: var(--text-primary) !important;
    }

    .form-control {
        background: var(--bg-primary) !important;
        border-color: var(--border-color) !important;
        color: var(--text-primary) !important;
    }

    .form-control:focus {
        background: var(--bg-primary) !important;
        border-color: var(--primary-color) !important;
        color: var(--text-primary) !important;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
    }

    .form-control::placeholder {
        color: var(--text-muted) !important;
    }

    .form-check-label {
        color: var(--text-primary) !important;
    }

    .form-check-input:checked {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
    }

    .form-check-input:focus {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
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

    .nav-tabs .nav-link {
        color: var(--text-secondary) !important;
    }

    .nav-tabs .nav-link.active {
        color: white !important;
    }

    .nav-tabs .nav-link:hover {
        color: var(--text-primary) !important;
    }

    .tab-content {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
        border-top: none !important;
    }

    .tab-pane {
        color: var(--text-primary) !important;
    }

    .alert {
        color: var(--text-primary) !important;
    }

    .alert-success {
        background: rgba(67, 233, 123, 0.1) !important;
        border-left: 4px solid #43e97b !important;
        color: #43e97b !important;
    }

    .alert-danger {
        background: rgba(255, 107, 107, 0.1) !important;
        border-left: 4px solid #ff6b6b !important;
        color: #ff6b6b !important;
    }

    /* Responsive para móvil */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 0.5rem;
        }

        .display-4 {
            font-size: 2rem;
        }

        .card {
            margin-bottom: 1rem;
        }

        .card-body {
            padding: 1rem;
        }

        .btn {
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .form-control, .form-select {
            font-size: 16px; /* Evita zoom en iOS */
        }

        .row.g-3 {
            --bs-gutter-x: 1rem;
        }

        .col-lg-4 {
            margin-top: 1rem;
        }

        .sticky-top {
            position: relative !important;
            top: auto !important;
        }

        .d-grid.gap-2 {
            gap: 0.5rem !important;
        }

        .btn-sm {
            padding: 0.5rem 0.75rem;
            font-size: 0.8rem;
        }

        .preview-container {
            padding: 0.75rem;
        }

        .theme-preview {
            height: 50px;
        }

        .list-unstyled li {
            font-size: 0.85rem;
        }
    }

    @media (max-width: 576px) {
        .display-4 {
            font-size: 1.75rem;
        }

        .card-header h5, .card-header h6 {
            font-size: 1rem;
        }

        .btn {
            padding: 0.5rem 0.75rem;
            font-size: 0.85rem;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .preview-container {
            padding: 0.5rem;
        }

        .theme-preview {
            height: 40px;
        }

        .d-grid.gap-2 .btn {
            padding: 0.4rem 0.6rem;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .container-fluid {
            padding: 0.25rem;
        }

        .card-body {
            padding: 0.75rem;
        }

        .btn {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
        }

        .form-control, .form-select {
            padding: 0.5rem 0.75rem;
        }

        .display-4 {
            font-size: 1.5rem;
        }

        .text-muted {
            font-size: 0.8rem;
        }
    }
</style>
@endsection
