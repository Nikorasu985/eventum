@extends('layouts.principal')

@section('title', 'Crear Evento - Eventum')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-4 fw-bold mb-2">
                <span class="bg-gradient-primary" style="-webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Crear Nuevo Evento
                </span>
            </h1>
            <p class="text-muted fs-5">Diseña tu evento perfecto con todas las opciones avanzadas</p>
        </div>
        <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Volver a Eventos
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('eventos.store') }}" method="POST" id="eventoForm">
                @csrf
                
                <!-- Información Básica -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Información Básica
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Título del Evento *</label>
                                <input type="text" class="form-control" name="titulo" value="{{ old('titulo') }}" required>
                                @error('titulo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tipo de Presupuesto *</label>
                                <select class="form-control" name="id_tipo_presupuesto" required>
                                    <option value="">Seleccionar tipo</option>
                                    @foreach($tiposPresupuesto as $tipo)
                                        <option value="{{ $tipo->id_tipo_presupuesto }}" {{ old('id_tipo_presupuesto') == $tipo->id_tipo_presupuesto ? 'selected' : '' }}>
                                            {{ ucfirst($tipo->nombre_tipo) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_tipo_presupuesto')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="4" placeholder="Describe tu evento...">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Ubicación y Fechas -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-calendar-alt me-2 text-success"></i>
                            Fechas y Ubicación
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Inicio *</label>
                                <input type="date" class="form-control" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                                @error('fecha_inicio')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hora de Inicio</label>
                                <input type="time" class="form-control" name="hora_inicio" value="{{ old('hora_inicio') }}">
                                @error('hora_inicio')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" name="fecha_fin" value="{{ old('fecha_fin') }}">
                                @error('fecha_fin')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hora de Fin</label>
                                <input type="time" class="form-control" name="hora_fin" value="{{ old('hora_fin') }}">
                                @error('hora_fin')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label">Lugar</label>
                                <input type="text" class="form-control" name="lugar" id="lugarInput" value="{{ old('lugar') }}" placeholder="Dirección o nombre del lugar" onkeyup="buscarLugar()">
                                <div id="sugerenciasLugar" class="list-group mt-2" style="display: none;"></div>
                                @error('lugar')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sitio Web</label>
                                <input type="url" class="form-control" name="sitio" value="{{ old('sitio') }}" placeholder="https://ejemplo.com">
                                @error('sitio')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Mapa de ubicación -->
                        <div class="mt-3" id="mapaContainer" style="display: none;">
                            <label class="form-label">Ubicación en el mapa</label>
                            <div id="mapa" style="height: 300px; width: 100%; border-radius: 8px; border: 1px solid var(--border-color);"></div>
                            <input type="hidden" name="latitud" id="latitud">
                            <input type="hidden" name="longitud" id="longitud">
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Fecha Límite de Invitación</label>
                            <input type="date" class="form-control" name="fecha_limite_invitacion" value="{{ old('fecha_limite_invitacion') }}">
                            <div class="form-text">Los invitados podrán unirse hasta esta fecha</div>
                            @error('fecha_limite_invitacion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Presupuesto y Participantes -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-dollar-sign me-2 text-warning"></i>
                            Presupuesto y Participantes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Presupuesto</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" name="presupuesto" value="{{ old('presupuesto') }}" step="0.01" min="0" placeholder="0.00">
                                </div>
                                @error('presupuesto')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Número de Integrantes</label>
                                <input type="number" class="form-control" name="numero_integrantes" value="{{ old('numero_integrantes', 0) }}" min="0">
                                @error('numero_integrantes')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-3">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save me-2"></i>
                        Crear Evento
                    </button>
                    <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-times me-2"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Panel lateral con ayuda -->
        <div class="col-lg-4">
            <div class="card consejos-fijos">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb me-2 text-warning"></i>
                        Consejos para tu Evento
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-primary">📝 Título Atractivo</h6>
                        <p class="small text-muted">Usa un título claro y descriptivo que llame la atención de los participantes.</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-success">📅 Fechas Importantes</h6>
                        <p class="small text-muted">Establece fechas límite para las invitaciones para tener mejor control.</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-info">💰 Presupuesto</h6>
                        <p class="small text-muted">Define si el presupuesto es fijo o solo una sugerencia para los participantes.</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-warning">📍 Ubicación</h6>
                        <p class="small text-muted">Incluye la dirección completa o enlace para reuniones virtuales.</p>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Tip:</strong> Tu evento generará automáticamente un código único para que otros puedan unirse fácilmente.
                    </div>
                </div>
            </div>

            <!-- Vista previa del evento -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-eye me-2 text-primary"></i>
                        Vista Previa
                    </h6>
                </div>
                <div class="card-body">
                    <div id="eventoPreview" class="text-center text-muted">
                        <i class="fas fa-calendar-plus fs-1 mb-3"></i>
                        <p>Completa el formulario para ver la vista previa</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .card-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.2);
    }

    .input-group-text {
        background: var(--bg-tertiary);
        border-color: var(--border-color);
        color: var(--text-primary);
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
    // Vista previa en tiempo real
    function actualizarVistaPrevia() {
        const titulo = document.querySelector('input[name="titulo"]').value;
        const descripcion = document.querySelector('textarea[name="descripcion"]').value;
        const fecha = document.querySelector('input[name="fecha_inicio"]').value;
        const hora = document.querySelector('input[name="hora_inicio"]').value;
        const lugar = document.querySelector('input[name="lugar"]').value;
        const presupuesto = document.querySelector('input[name="presupuesto"]').value;

        const preview = document.getElementById('eventoPreview');
        
        if (titulo) {
            preview.innerHTML = `
                <div class="text-start">
                    <h5 class="text-primary mb-2">${titulo}</h5>
                    ${descripcion ? `<p class="small text-muted mb-2">${descripcion}</p>` : ''}
                    <div class="row g-2">
                        ${fecha ? `<div class="col-6"><small class="text-muted">Fecha:</small><br><strong>${new Date(fecha).toLocaleDateString('es-ES')}</strong></div>` : ''}
                        ${hora ? `<div class="col-6"><small class="text-muted">Hora:</small><br><strong>${hora}</strong></div>` : ''}
                        ${lugar ? `<div class="col-12"><small class="text-muted">Lugar:</small><br><strong>${lugar}</strong></div>` : ''}
                        ${presupuesto ? `<div class="col-12"><small class="text-muted">Presupuesto:</small><br><strong>$${parseFloat(presupuesto).toFixed(2)}</strong></div>` : ''}
                    </div>
                </div>
            `;
        } else {
            preview.innerHTML = `
                <i class="fas fa-calendar-plus fs-1 mb-3"></i>
                <p>Completa el formulario para ver la vista previa</p>
            `;
        }
    }

    // Agregar event listeners para actualizar la vista previa
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = ['titulo', 'descripcion', 'fecha_inicio', 'hora_inicio', 'lugar', 'presupuesto'];
        inputs.forEach(inputName => {
            const input = document.querySelector(`input[name="${inputName}"], textarea[name="${inputName}"]`);
            if (input) {
                input.addEventListener('input', actualizarVistaPrevia);
            }
        });

        // Establecer fecha mínima como hoy
        const fechaInput = document.querySelector('input[name="fecha_inicio"]');
        if (fechaInput) {
            fechaInput.min = new Date().toISOString().split('T')[0];
        }

        // Validación en tiempo real
        const form = document.getElementById('eventoForm');
        form.addEventListener('submit', function(e) {
            const titulo = document.querySelector('input[name="titulo"]').value.trim();
            const fechaInicio = document.querySelector('input[name="fecha_inicio"]').value;
            
            if (!titulo) {
                e.preventDefault();
                alert('El título del evento es obligatorio');
                return;
            }
            
            if (!fechaInicio) {
                e.preventDefault();
                alert('La fecha de inicio es obligatoria');
                return;
            }

            // Mostrar loading
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creando Evento...';
            submitBtn.disabled = true;
        });
    });

    // Google Maps API
    let mapa;
    let marcador;
    let servicioAutocompletado;

    function initMap() {
        // Inicializar el mapa
        mapa = new google.maps.Map(document.getElementById('mapa'), {
            center: { lat: 19.4326, lng: -99.1332 }, // Ciudad de México
            zoom: 13
        });

        // Inicializar el servicio de autocompletado
        servicioAutocompletado = new google.maps.places.AutocompleteService();
    }

    function buscarLugar() {
        const input = document.getElementById('lugarInput');
        const sugerencias = document.getElementById('sugerenciasLugar');
        
        if (input.value.length < 3) {
            sugerencias.style.display = 'none';
            return;
        }

        servicioAutocompletado.getPlacePredictions({
            input: input.value,
            types: ['establishment', 'geocode']
        }, (predictions, status) => {
            if (status === google.maps.places.PlacesServiceStatus.OK && predictions) {
                mostrarSugerencias(predictions);
            }
        });
    }

    function mostrarSugerencias(predictions) {
        const sugerencias = document.getElementById('sugerenciasLugar');
        sugerencias.innerHTML = '';
        
        predictions.forEach(prediction => {
            const item = document.createElement('div');
            item.className = 'list-group-item list-group-item-action';
            item.textContent = prediction.description;
            item.onclick = () => seleccionarLugar(prediction);
            sugerencias.appendChild(item);
        });
        
        sugerencias.style.display = 'block';
    }

    function seleccionarLugar(prediction) {
        const input = document.getElementById('lugarInput');
        const sugerencias = document.getElementById('sugerenciasLugar');
        
        input.value = prediction.description;
        sugerencias.style.display = 'none';
        
        // Buscar coordenadas del lugar
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ placeId: prediction.place_id }, (results, status) => {
            if (status === 'OK' && results[0]) {
                const lugar = results[0].geometry.location;
                mostrarMapa(lugar.lat(), lugar.lng());
            }
        });
    }

    function mostrarMapa(lat, lng) {
        const container = document.getElementById('mapaContainer');
        container.style.display = 'block';
        
        if (!mapa) {
            initMap();
        }
        
        const ubicacion = { lat: lat, lng: lng };
        mapa.setCenter(ubicacion);
        
        if (marcador) {
            marcador.setMap(null);
        }
        
        marcador = new google.maps.Marker({
            position: ubicacion,
            map: mapa,
            draggable: true
        });
        
        document.getElementById('latitud').value = lat;
        document.getElementById('longitud').value = lng;
        
        marcador.addListener('dragend', () => {
            const pos = marcador.getPosition();
            document.getElementById('latitud').value = pos.lat();
            document.getElementById('longitud').value = pos.lng();
        });
    }
</script>

<!-- Google Maps API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvOkBwJcTkF5j5Q5Q5Q5Q5Q5Q5Q5Q5Q5Q5Q&libraries=places&callback=initMap"></script>
@endsection

@section('styles')
<style>
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

    .btn-outline-secondary {
        color: var(--text-secondary) !important;
        border-color: var(--border-color) !important;
    }

    .btn-outline-secondary:hover {
        color: white !important;
        background-color: var(--text-secondary) !important;
    }

    .card {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
    }

    .card-header {
        background: var(--bg-tertiary) !important;
        border-bottom: 1px solid var(--border-color) !important;
    }
</style>
@endsection
