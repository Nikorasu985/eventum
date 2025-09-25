@extends('layouts.principal')

@section('title', 'Mi Perfil - Eventum')

@section('content')
<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4 fw-bold">
            <span style="background: var(--gradient-primary); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                Mi Perfil
            </span>
        </h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Información Personal</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('usuarios.actualizar-perfil') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" 
                                       value="{{ Auth::user()->nombre_usuario }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" 
                                       value="{{ Auth::user()->correo }}" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contraseña_actual" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control" id="contraseña_actual" name="contraseña_actual">
                            <div class="form-text">Deja en blanco si no quieres cambiar la contraseña</div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nueva_contraseña" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="nueva_contraseña" name="nueva_contraseña">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="confirmar_contraseña" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="confirmar_contraseña" name="nueva_contraseña_confirmation">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Actualizar Perfil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Información de Cuenta</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Rol del Sistema:</strong>
                        <span class="badge bg-primary ms-2">{{ Auth::user()->rolSistema->nombre_rol }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Miembro desde:</strong>
                        <span class="text-muted">{{ Auth::user()->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Eventos Creados:</strong>
                        <span class="text-muted">{{ Auth::user()->eventosCreados()->count() }}</span>
                    </div>
                    <div class="mb-3">
                        <strong>Eventos Participando:</strong>
                        <span class="text-muted">{{ Auth::user()->eventosParticipando()->count() }}</span>
                    </div>
                </div>
            </div>
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
