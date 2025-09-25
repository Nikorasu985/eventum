@extends('layouts.principal')

@section('title', 'Mis Reportes - Eventum')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4 fw-bold">
            <span style="background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                Mis Reportes
            </span>
        </h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearReporteModal">
            <i class="fas fa-plus me-2"></i>Crear Reporte
        </button>
    </div>

    @if($reportes->count() > 0)
        <div class="row">
            @foreach($reportes as $reporte)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card report-card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary fw-bold">{{ $reporte->evento->titulo }}</h5>
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit($reporte->motivo, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="badge bg-secondary">{{ $reporte->fecha_reporte->format('d M Y') }}</span>
                                <small class="text-muted">Reporte #{{ $reporte->id_reporte }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $reportes->links() }}
        </div>
    @else
        <div class="alert alert-info text-center fade-in" role="alert">
            <i class="fas fa-info-circle me-2"></i>No tienes reportes enviados. ¡Anímate a crear uno si encuentras algún problema!
        </div>
    @endif
</div>

<!-- Modal para crear reporte -->
<div class="modal fade" id="crearReporteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nuevo Reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('reportes.crear') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id_evento" class="form-label">Evento a Reportar</label>
                        <select class="form-control" id="id_evento" name="id_evento" required>
                            <option value="">Selecciona un evento</option>
                            @foreach(Auth::user()->eventosParticipando as $evento)
                                <option value="{{ $evento->id_evento }}">{{ $evento->titulo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo del Reporte</label>
                        <textarea class="form-control" id="motivo" name="motivo" rows="4" 
                                  placeholder="Describe el problema o situación que quieres reportar..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Enviar Reporte</button>
                </div>
            </form>
        </div>
    </div>
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

    .report-card {
        background: var(--bg-secondary) !important;
        border: 1px solid var(--border-color) !important;
    }

    .report-card .card-title {
        color: var(--text-primary) !important;
    }

    .report-card .card-text {
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

    .modal-content {
        background: var(--bg-secondary) !important;
        color: var(--text-primary) !important;
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
</style>
@endsection
