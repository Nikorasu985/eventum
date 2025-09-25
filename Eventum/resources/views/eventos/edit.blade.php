@extends('layouts.principal')

@section('title', 'Editar Evento - Eventum')

@section('content')
<div class="fade-in">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-4 fw-bold mb-2">
                <span class="bg-gradient-primary" style="-webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Editar Evento
                </span>
            </h1>
            <p class="text-muted fs-5">Modifica los detalles de tu evento</p>
        </div>
        <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Volver al Evento
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('eventos.update', $evento->id_evento) }}" method="POST" id="eventoForm">
                @csrf
                @method('PUT')
                
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
                                <input type="text" class="form-control" name="titulo" value="{{ old('titulo', $evento->titulo) }}" required>
                                @error('titulo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tipo de Presupuesto *</label>
                                <select class="form-control" name="id_tipo_presupuesto" required>
                                    @foreach($tiposPresupuesto as $tipo)
                                        <option value="{{ $tipo->id_tipo_presupuesto }}" 
                                                {{ old('id_tipo_presupuesto', $evento->id_tipo_presupuesto) == $tipo->id_tipo_presupuesto ? 'selected' : '' }}>
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
                            <textarea class="form-control" name="descripcion" rows="4" placeholder="Describe tu evento...">{{ old('descripcion', $evento->descripcion) }}</textarea>
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
                                <input type="date" class="form-control" name="fecha_inicio" value="{{ old('fecha_inicio', $evento->fecha_inicio->format('Y-m-d')) }}" required>
                                @error('fecha_inicio')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hora de Inicio</label>
                                <input type="time" class="form-control" name="hora_inicio" value="{{ old('hora_inicio', $evento->hora_inicio) }}">
                                @error('hora_inicio')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label">Fecha de Fin</label>
                                <input type="date" class="form-control" name="fecha_fin" value="{{ old('fecha_fin', $evento->fecha_fin ? $evento->fecha_fin->format('Y-m-d') : '') }}">
                                @error('fecha_fin')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Hora de Fin</label>
                                <input type="time" class="form-control" name="hora_fin" value="{{ old('hora_fin', $evento->hora_fin) }}">
                                @error('hora_fin')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label class="form-label">Lugar</label>
                                <input type="text" class="form-control" name="lugar" value="{{ old('lugar', $evento->lugar) }}" placeholder="Dirección o nombre del lugar">
                                @error('lugar')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sitio Web</label>
                                <input type="url" class="form-control" name="sitio" value="{{ old('sitio', $evento->sitio) }}" placeholder="https://ejemplo.com">
                                @error('sitio')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label class="form-label">Fecha Límite de Invitación</label>
                            <input type="date" class="form-control" name="fecha_limite_invitacion" value="{{ old('fecha_limite_invitacion', $evento->fecha_limite_invitacion ? $evento->fecha_limite_invitacion->format('Y-m-d') : '') }}">
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
                                    <input type="number" class="form-control" name="presupuesto" value="{{ old('presupuesto', $evento->presupuesto) }}" step="0.01" min="0" placeholder="0.00">
                                </div>
                                @error('presupuesto')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Número de Integrantes</label>
                                <input type="number" class="form-control" name="numero_integrantes" value="{{ old('numero_integrantes', $evento->numero_integrantes) }}" min="0">
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
                        Guardar Cambios
                    </button>
                    <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-times me-2"></i>
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <!-- Panel lateral con información del evento -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Información del Evento
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-muted">Código del Evento</h6>
                        <div class="d-flex align-items-center">
                            <code class="bg-light px-2 py-1 rounded flex-grow-1">{{ $evento->codigo_evento }}</code>
                            <button class="btn btn-sm btn-outline-primary ms-2" onclick="copiarCodigo('{{ $evento->codigo_evento }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">Creado</h6>
                        <p class="mb-0">{{ $evento->created_at->format('d M Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-muted">Última actualización</h6>
                        <p class="mb-0">{{ $evento->updated_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tip:</strong> Los cambios se aplicarán inmediatamente a todos los participantes.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copiarCodigo(codigo) {
        navigator.clipboard.writeText(codigo).then(function() {
            alert('Código copiado al portapapeles');
        });
    }

    // Validación en tiempo real
    document.addEventListener('DOMContentLoaded', function() {
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
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Guardando...';
            submitBtn.disabled = true;
        });
    });
</script>
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
