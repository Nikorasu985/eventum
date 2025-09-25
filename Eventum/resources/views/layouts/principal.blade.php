<!DOCTYPE html>
<html lang="es" data-theme="{{ Auth::check() && Auth::user()->configuracion ? Auth::user()->configuracion->tema : 'minimalista' }}" data-dark-mode="{{ Auth::check() && Auth::user()->configuracion ? Auth::user()->configuracion->modo_oscuro : 'dark' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Eventum - Gestión de Eventos')</title>
    
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/eventum-themes.css') }}" rel="stylesheet">
    
    <style>
        :root {
            /* Colores principales - se pueden personalizar */
            --primary-color: {{ Auth::check() && Auth::user()->configuracion ? (json_decode(Auth::user()->configuracion->colores_personalizados, true)['primary'] ?? '#667eea') : '#667eea' }};
            --secondary-color: {{ Auth::check() && Auth::user()->configuracion ? (json_decode(Auth::user()->configuracion->colores_personalizados, true)['secondary'] ?? '#764ba2') : '#764ba2' }};
            --accent-color: {{ Auth::check() && Auth::user()->configuracion ? (json_decode(Auth::user()->configuracion->colores_personalizados, true)['accent'] ?? '#f093fb') : '#f093fb' }};
            --success-color: {{ Auth::check() && Auth::user()->configuracion ? (json_decode(Auth::user()->configuracion->colores_personalizados, true)['success'] ?? '#43e97b') : '#43e97b' }};
            --warning-color: {{ Auth::check() && Auth::user()->configuracion ? (json_decode(Auth::user()->configuracion->colores_personalizados, true)['warning'] ?? '#fa709a') : '#fa709a' }};
            --danger-color: {{ Auth::check() && Auth::user()->configuracion ? (json_decode(Auth::user()->configuracion->colores_personalizados, true)['danger'] ?? '#ff6b6b') : '#ff6b6b' }};
            
            /* Modo oscuro */
            --bg-primary: #0a0a0a;
            --bg-secondary: #1a1a1a;
            --bg-tertiary: #2a2a2a;
            --text-primary: #ffffff;
            --text-secondary: #e0e0e0;
            --text-muted: #b0b0b0;
            --border-color: #404040;
            --shadow: rgba(0, 0, 0, 0.3);
            --info-color: #17a2b8;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            
            /* Gradientes */
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --gradient-warning: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --gradient-danger: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            
            /* Fuentes - personalizables */
            --font-primary: '{{ Auth::check() && Auth::user()->configuracion ? (Auth::user()->configuracion->tipo_fuente ?? 'Inter') : 'Inter' }}', sans-serif;
            --font-heading: '{{ Auth::check() && Auth::user()->configuracion ? (Auth::user()->configuracion->tipo_fuente ?? 'Space Grotesk') : 'Space Grotesk' }}', sans-serif;
            --font-size-base: {{ Auth::check() && Auth::user()->configuracion ? (Auth::user()->configuracion->tamaño_fuente ?? 16) : 16 }}px;
            
            /* Espaciado */
            --border-radius: 12px;
            --border-radius-sm: 8px;
            --border-radius-lg: 16px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Modo claro */
        [data-dark-mode="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --shadow: rgba(0, 0, 0, 0.08);
            --info-color: #0ea5e9;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }

        /* Iconos en modo claro */
        [data-dark-mode="light"] .fas,
        [data-dark-mode="light"] .far,
        [data-dark-mode="light"] .fab {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .nav-link i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .btn i {
            color: inherit !important;
        }

        [data-dark-mode="light"] .card-header i {
            color: var(--primary-color) !important;
        }

        [data-dark-mode="light"] .stat-icon i {
            color: white !important;
        }

        [data-dark-mode="light"] .input-group-icon {
            color: var(--text-muted) !important;
        }

        /* Asegurar visibilidad de iconos en todos los temas y modos */
        .fas, .far, .fab, .fa {
            color: var(--text-primary) !important;
        }

        .nav-link i {
            color: var(--text-primary) !important;
        }

        .btn i {
            color: inherit !important;
        }

        .card-header i {
            color: var(--primary-color) !important;
        }

        .stat-icon i {
            color: white !important;
        }

        .input-group-icon {
            color: var(--text-muted) !important;
        }

        /* Iconos específicos que pueden desaparecer */
        .text-warning i {
            color: var(--warning-color) !important;
        }

        .text-primary i {
            color: var(--primary-color) !important;
        }

        .text-success i {
            color: var(--success-color) !important;
        }

        .text-info i {
            color: var(--info-color) !important;
        }

        .text-danger i {
            color: var(--danger-color) !important;
        }

        .text-secondary i {
            color: var(--text-secondary) !important;
        }

        .text-muted i {
            color: var(--text-muted) !important;
        }

        /* Asegurar que los iconos en botones sean visibles */
        .btn-primary i {
            color: white !important;
        }

        .btn-secondary i {
            color: white !important;
        }

        .btn-success i {
            color: white !important;
        }

        .btn-danger i {
            color: white !important;
        }

        .btn-warning i {
            color: white !important;
        }

        .btn-info i {
            color: white !important;
        }

        .btn-outline-primary i {
            color: var(--primary-color) !important;
        }

        .btn-outline-secondary i {
            color: var(--text-secondary) !important;
        }

        .btn-outline-success i {
            color: var(--success-color) !important;
        }

        .btn-outline-danger i {
            color: var(--danger-color) !important;
        }

        .btn-outline-warning i {
            color: var(--warning-color) !important;
        }

        .btn-outline-info i {
            color: var(--info-color) !important;
        }

        /* Iconos en elementos específicos */
        .alert i {
            color: inherit !important;
        }

        .badge i {
            color: inherit !important;
        }

        .dropdown-item i {
            color: var(--text-primary) !important;
        }

        .list-group-item i {
            color: var(--text-primary) !important;
        }

        .table i {
            color: var(--text-primary) !important;
        }

        /* Asegurar contraste en modo claro */
        [data-dark-mode="light"] .fas,
        [data-dark-mode="light"] .far,
        [data-dark-mode="light"] .fab {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .text-warning i {
            color: #f59e0b !important;
        }

        [data-dark-mode="light"] .text-primary i {
            color: var(--primary-color) !important;
        }

        [data-dark-mode="light"] .text-success i {
            color: #198754 !important;
        }

        [data-dark-mode="light"] .text-info i {
            color: #0dcaf0 !important;
        }

        [data-dark-mode="light"] .text-danger i {
            color: #dc3545 !important;
        }

        [data-dark-mode="light"] .text-secondary i {
            color: #6c757d !important;
        }

        [data-dark-mode="light"] .text-muted i {
            color: #6c757d !important;
        }

        /* Asegurar que los iconos sean visibles en modo claro */
        [data-dark-mode="light"] .nav-link i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .btn i {
            color: inherit !important;
        }

        [data-dark-mode="light"] .card-header i {
            color: var(--primary-color) !important;
        }

        [data-dark-mode="light"] .stat-icon i {
            color: white !important;
        }

        [data-dark-mode="light"] .input-group-icon {
            color: var(--text-muted) !important;
        }

        [data-dark-mode="light"] .navbar-brand i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .dropdown-toggle i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .badge i {
            color: inherit !important;
        }

        [data-dark-mode="light"] .alert i {
            color: inherit !important;
        }

        [data-dark-mode="light"] .list-group-item i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .table i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .modal-header i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .modal-body i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .breadcrumb i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .pagination i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .form-label i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .form-text i {
            color: var(--text-muted) !important;
        }

        [data-dark-mode="light"] .invalid-feedback i {
            color: var(--danger-color) !important;
        }

        [data-dark-mode="light"] .valid-feedback i {
            color: var(--success-color) !important;
        }

        /* Iconos específicos del dashboard que desaparecen */
        [data-dark-mode="light"] .fas.fa-calendar,
        [data-dark-mode="light"] .fas.fa-users,
        [data-dark-mode="light"] .fas.fa-envelope,
        [data-dark-mode="light"] .fas.fa-bell,
        [data-dark-mode="light"] .fas.fa-plus,
        [data-dark-mode="light"] .fas.fa-user-friends,
        [data-dark-mode="light"] .fas.fa-bell,
        [data-dark-mode="light"] .fas.fa-envelope-open {
            color: var(--text-primary) !important;
        }

        /* Reglas específicas de personalización - se mantienen aquí para dinamicidad */

        /* Asegurar que todos los iconos del dashboard sean visibles */
        [data-dark-mode="light"] .card .fas,
        [data-dark-mode="light"] .card .far,
        [data-dark-mode="light"] .card .fab {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .card-header .fas,
        [data-dark-mode="light"] .card-header .far,
        [data-dark-mode="light"] .card-header .fab {
            color: var(--primary-color) !important;
        }

        /* Iconos específicos que pueden ser blancos en modo claro */
        [data-dark-mode="light"] .btn-primary i {
            color: white !important;
        }

        [data-dark-mode="light"] .btn-secondary i {
            color: white !important;
        }

        [data-dark-mode="light"] .btn-success i {
            color: white !important;
        }

        [data-dark-mode="light"] .btn-danger i {
            color: white !important;
        }

        [data-dark-mode="light"] .btn-warning i {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .btn-info i {
            color: white !important;
        }

        [data-dark-mode="light"] .btn-outline-primary i {
            color: var(--primary-color) !important;
        }

        [data-dark-mode="light"] .btn-outline-secondary i {
            color: var(--text-secondary) !important;
        }

        [data-dark-mode="light"] .btn-outline-success i {
            color: var(--success-color) !important;
        }

        [data-dark-mode="light"] .btn-outline-danger i {
            color: var(--danger-color) !important;
        }

        [data-dark-mode="light"] .btn-outline-warning i {
            color: var(--warning-color) !important;
        }

        [data-dark-mode="light"] .btn-outline-info i {
            color: var(--info-color) !important;
        }

        /* Asegurar que los iconos en elementos activos sean visibles */
        [data-dark-mode="light"] .nav-link.active i {
            color: white !important;
        }

        [data-dark-mode="light"] .estilo-btn.active i {
            color: white !important;
        }

        [data-dark-mode="light"] .list-group-item.active i {
            color: white !important;
        }

        [data-dark-mode="light"] .dropdown-item.active i {
            color: white !important;
        }

        [data-dark-mode="light"] .pagination .page-item.active .page-link i {
            color: white !important;
        }

        /* Botones específicos que desaparecen en modo claro */
        [data-dark-mode="light"] .btn-outline-primary,
        [data-dark-mode="light"] .btn-outline-secondary,
        [data-dark-mode="light"] .btn-outline-success,
        [data-dark-mode="light"] .btn-outline-danger,
        [data-dark-mode="light"] .btn-outline-warning,
        [data-dark-mode="light"] .btn-outline-info {
            color: var(--text-primary) !important;
            border-color: var(--text-primary) !important;
            background: transparent !important;
        }

        [data-dark-mode="light"] .btn-outline-primary:hover,
        [data-dark-mode="light"] .btn-outline-secondary:hover,
        [data-dark-mode="light"] .btn-outline-success:hover,
        [data-dark-mode="light"] .btn-outline-danger:hover,
        [data-dark-mode="light"] .btn-outline-warning:hover,
        [data-dark-mode="light"] .btn-outline-info:hover {
            color: white !important;
            background: var(--primary-color) !important;
        }

        /* Slider de tamaño de fuente */
        [data-dark-mode="light"] .form-range {
            background: var(--bg-primary) !important;
        }

        [data-dark-mode="light"] .form-range::-webkit-slider-thumb {
            background: var(--primary-color) !important;
        }

        [data-dark-mode="light"] .form-range::-moz-range-thumb {
            background: var(--primary-color) !important;
        }

        /* Labels y textos de ejemplo */
        [data-dark-mode="light"] .form-label {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .form-text {
            color: var(--text-muted) !important;
        }

        [data-dark-mode="light"] .small {
            color: var(--text-muted) !important;
        }

        /* Badges y etiquetas */
        [data-dark-mode="light"] .badge {
            color: white !important;
        }

        [data-dark-mode="light"] .badge.bg-primary {
            background: var(--primary-color) !important;
            color: white !important;
        }

        [data-dark-mode="light"] .badge.bg-secondary {
            background: var(--text-secondary) !important;
            color: white !important;
        }

        [data-dark-mode="light"] .badge.bg-success {
            background: var(--success-color) !important;
            color: white !important;
        }

        [data-dark-mode="light"] .badge.bg-danger {
            background: var(--danger-color) !important;
            color: white !important;
        }

        [data-dark-mode="light"] .badge.bg-warning {
            background: var(--warning-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .badge.bg-info {
            background: var(--info-color) !important;
            color: white !important;
        }

        /* Mejorar contraste en todos los temas para modo claro */
        [data-dark-mode="light"] {
            --text-primary: #1a1a1a;
            --text-secondary: #4a4a4a;
            --text-muted: #6a6a6a;
            --border-color: #d0d0d0;
        }

        /* Asegurar que todos los elementos tengan contraste adecuado en modo claro */
        [data-dark-mode="light"] .card {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .card-header {
            background: var(--bg-tertiary) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .card-body {
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .card-footer {
            background: var(--bg-tertiary) !important;
            border-top: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .modal-content {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .modal-header {
            background: var(--bg-tertiary) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .modal-body {
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .modal-footer {
            background: var(--bg-tertiary) !important;
            border-top: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .offcanvas {
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .offcanvas-header {
            background: var(--bg-tertiary) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .offcanvas-body {
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .accordion {
            background: var(--bg-secondary) !important;
        }

        [data-dark-mode="light"] .accordion-item {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
        }

        [data-dark-mode="light"] .accordion-header {
            background: var(--bg-tertiary) !important;
        }

        [data-dark-mode="light"] .accordion-button {
            background: var(--bg-tertiary) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .accordion-button:not(.collapsed) {
            background: var(--primary-color) !important;
            color: white !important;
        }

        [data-dark-mode="light"] .accordion-body {
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .carousel {
            background: var(--bg-secondary) !important;
        }

        [data-dark-mode="light"] .carousel-item {
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .carousel-caption {
            background: rgba(0, 0, 0, 0.5) !important;
            color: white !important;
        }

        [data-dark-mode="light"] .carousel-control-prev,
        [data-dark-mode="light"] .carousel-control-next {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .carousel-indicators button {
            background: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .carousel-indicators .active {
            background: var(--primary-color) !important;
        }

        [data-dark-mode="light"] .spinner-border {
            color: var(--primary-color) !important;
        }

        [data-dark-mode="light"] .spinner-grow {
            color: var(--primary-color) !important;
        }

        [data-dark-mode="light"] .progress {
            background: var(--bg-tertiary) !important;
        }

        [data-dark-mode="light"] .progress-bar {
            background: var(--primary-color) !important;
        }

        [data-dark-mode="light"] .toast {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .toast-header {
            background: var(--bg-tertiary) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .toast-body {
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .tooltip {
            background: var(--bg-primary) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .popover {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .popover-header {
            background: var(--bg-tertiary) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .popover-body {
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        /* Asegurar que los elementos específicos de cada tema funcionen en modo claro */
        [data-theme="neon"][data-dark-mode="light"] {
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --gradient-primary: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
            --gradient-secondary: linear-gradient(135deg, #ff0080 0%, #ff8c00 100%);
            --gradient-accent: linear-gradient(135deg, #00d4ff 0%, #ff0080 100%);
        }

        [data-theme="cyber"][data-dark-mode="light"] {
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --gradient-primary: linear-gradient(135deg, #00ff41 0%, #00d4aa 100%);
            --gradient-secondary: linear-gradient(135deg, #ff0040 0%, #ff8c00 100%);
            --gradient-accent: linear-gradient(135deg, #00d4aa 0%, #ff0040 100%);
        }

        [data-theme="futurista"][data-dark-mode="light"] {
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        [data-theme="minimalista"][data-dark-mode="light"] {
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --gradient-primary: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --gradient-secondary: linear-gradient(135deg, #7c3aed 0%, #db2777 100%);
            --gradient-accent: linear-gradient(135deg, #db2777 0%, #4f46e5 100%);
        }

        [data-theme="monocromatico"][data-dark-mode="light"] {
            --text-primary: #000000;
            --text-secondary: #333333;
            --text-muted: #666666;
            --gradient-primary: linear-gradient(135deg, #4a4a4a 0%, #6b6b6b 100%);
            --gradient-secondary: linear-gradient(135deg, #6b6b6b 0%, #8a8a8a 100%);
            --gradient-accent: linear-gradient(135deg, #8a8a8a 0%, #4a4a4a 100%);
        }

        /* Asegurar que los títulos con gradientes funcionen en modo claro */
        [data-dark-mode="light"] .gradient-text {
            background: var(--gradient-primary) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        [data-dark-mode="light"] .gradient-text-secondary {
            background: var(--gradient-secondary) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        [data-dark-mode="light"] .gradient-text-accent {
            background: var(--gradient-accent) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        /* Fallback específico para modo claro */
        @supports not (-webkit-background-clip: text) {
            [data-dark-mode="light"] .gradient-text {
                color: var(--primary-color) !important;
                background: none !important;
            }

            [data-dark-mode="light"] .gradient-text-secondary {
                color: var(--secondary-color) !important;
                background: none !important;
            }

            [data-dark-mode="light"] .gradient-text-accent {
                color: var(--accent-color) !important;
                background: none !important;
            }
        }

        /* Temas personalizados */
        [data-theme="neon"] {
            --primary-color: #00ff88;
            --secondary-color: #00d4ff;
            --accent-color: #ff0080;
            --success-color: #00ff88;
            --warning-color: #ffaa00;
            --danger-color: #ff0040;
            --gradient-primary: linear-gradient(135deg, #00ff88 0%, #00d4ff 100%);
            --gradient-secondary: linear-gradient(135deg, #ff0080 0%, #ffaa00 100%);
            --gradient-accent: linear-gradient(135deg, #00d4ff 0%, #ff0080 100%);
        }

        [data-theme="neon"][data-dark-mode="light"] {
            --primary-color: #00cc6a;
            --secondary-color: #00a8cc;
            --accent-color: #cc0066;
            --gradient-primary: linear-gradient(135deg, #00cc6a 0%, #00a8cc 100%);
            --gradient-secondary: linear-gradient(135deg, #cc0066 0%, #cc8800 100%);
            --gradient-accent: linear-gradient(135deg, #00a8cc 0%, #cc0066 100%);
        }

        [data-theme="cyber"] {
            --primary-color: #00aaff;
            --secondary-color: #6666ff;
            --accent-color: #00ff88;
            --success-color: #00ff88;
            --warning-color: #ffaa00;
            --danger-color: #ff3366;
            --gradient-primary: linear-gradient(135deg, #00aaff 0%, #0066cc 100%);
            --gradient-secondary: linear-gradient(135deg, #6666ff 0%, #4444cc 100%);
            --gradient-accent: linear-gradient(135deg, #00ff88 0%, #00cc66 100%);
        }

        [data-theme="cyber"][data-dark-mode="light"] {
            --primary-color: #0066cc;
            --secondary-color: #4444cc;
            --accent-color: #00cc66;
            --gradient-primary: linear-gradient(135deg, #0066cc 0%, #004499 100%);
            --gradient-secondary: linear-gradient(135deg, #4444cc 0%, #3333aa 100%);
            --gradient-accent: linear-gradient(135deg, #00cc66 0%, #00aa44 100%);
        }

        /* Tema monocromático eliminado */

        [data-theme="monocromatico"] .btn-outline-primary:hover {
            background: var(--primary-color) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .nav-link {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .nav-link:hover {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .nav-link.active {
            background: var(--gradient-primary) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .navbar-brand {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .form-control {
            background: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .form-select {
            background: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .form-label {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .form-text {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"] .small {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"] .text-muted {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"] .text-primary {
            color: var(--primary-color) !important;
        }

        [data-theme="monocromatico"] .text-secondary {
            color: var(--text-secondary) !important;
        }

        [data-theme="monocromatico"] .badge {
            color: white !important;
        }

        [data-theme="monocromatico"] .badge.bg-primary {
            background: var(--gradient-primary) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .badge.bg-secondary {
            background: var(--gradient-secondary) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .alert {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .alert-info {
            background-color: rgba(13, 202, 240, 0.1) !important;
            border-color: rgba(13, 202, 240, 0.2) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .alert-success {
            background-color: rgba(25, 135, 84, 0.1) !important;
            border-color: rgba(25, 135, 84, 0.2) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .alert-warning {
            background-color: rgba(255, 193, 7, 0.1) !important;
            border-color: rgba(255, 193, 7, 0.2) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .alert-danger {
            background-color: rgba(220, 53, 69, 0.1) !important;
            border-color: rgba(220, 53, 69, 0.2) !important;
            color: var(--text-primary) !important;
        }

        /* Reglas específicas para tema monocromático - Modo oscuro (fondo oscuro, texto blanco) */
        [data-theme="monocromatico"] h1,
        [data-theme="monocromatico"] h2,
        [data-theme="monocromatico"] h3,
        [data-theme="monocromatico"] h4,
        [data-theme="monocromatico"] h5,
        [data-theme="monocromatico"] h6,
        [data-theme="monocromatico"] p,
        [data-theme="monocromatico"] span,
        [data-theme="monocromatico"] div,
        [data-theme="monocromatico"] .card-title,
        [data-theme="monocromatico"] .card-text,
        [data-theme="monocromatico"] .text-muted,
        [data-theme="monocromatico"] .small,
        [data-theme="monocromatico"] .nav-link,
        [data-theme="monocromatico"] .navbar-brand {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"] .btn {
            background: #ffffff !important;
            color: #000000 !important;
            border: 1px solid #ffffff !important;
        }

        [data-theme="monocromatico"] .btn:hover {
            background: #f0f0f0 !important;
            color: #000000 !important;
        }

        [data-theme="monocromatico"] .btn i {
            color: #000000 !important;
        }

        [data-theme="monocromatico"] .fas,
        [data-theme="monocromatico"] .far,
        [data-theme="monocromatico"] .fab {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"] .btn .fas,
        [data-theme="monocromatico"] .btn .far,
        [data-theme="monocromatico"] .btn .fab {
            color: #000000 !important;
        }

        /* Iconos del dashboard en tema monocromático modo oscuro */
        [data-theme="monocromatico"] .card .fas.fa-calendar,
        [data-theme="monocromatico"] .card .fas.fa-users,
        [data-theme="monocromatico"] .card .fas.fa-envelope,
        [data-theme="monocromatico"] .card .fas.fa-bell,
        [data-theme="monocromatico"] .stat-icon .fas.fa-calendar,
        [data-theme="monocromatico"] .stat-icon .fas.fa-users,
        [data-theme="monocromatico"] .stat-icon .fas.fa-envelope,
        [data-theme="monocromatico"] .stat-icon .fas.fa-bell {
            color: #ffffff !important;
        }


        /* Reglas específicas para tema monocromático en modo claro - mayor prioridad */
        [data-theme="monocromatico"][data-dark-mode="light"] .btn .fas,
        [data-theme="monocromatico"][data-dark-mode="light"] .btn .far,
        [data-theme="monocromatico"][data-dark-mode="light"] .btn .fab {
            color: white !important;
        }

        /* Iconos específicos para tema monocromático */
        [data-theme="monocromatico"] .fas,
        [data-theme="monocromatico"] .far,
        [data-theme="monocromatico"] .fab {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .nav-link i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .btn i {
            color: inherit !important;
        }

        [data-theme="monocromatico"] .card-header i {
            color: var(--primary-color) !important;
        }

        [data-theme="monocromatico"] .stat-icon i {
            color: white !important;
        }

        [data-theme="monocromatico"] .navbar-brand i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .badge i {
            color: inherit !important;
        }

        [data-theme="monocromatico"] .alert i {
            color: inherit !important;
        }

        [data-theme="monocromatico"] .list-group-item i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .table i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .modal-header i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .modal-body i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .breadcrumb i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .pagination i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .form-label i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .form-text i {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"] .invalid-feedback i {
            color: var(--danger-color) !important;
        }

        [data-theme="monocromatico"] .valid-feedback i {
            color: var(--success-color) !important;
        }

        /* Botones específicos para tema monocromático */
        [data-theme="monocromatico"] .btn-primary i {
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .btn-secondary i {
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .btn-success i {
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .btn-danger i {
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .btn-warning i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .btn-info i {
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .btn-outline-primary i {
            color: var(--primary-color) !important;
        }

        [data-theme="monocromatico"] .btn-outline-secondary i {
            color: var(--text-secondary) !important;
        }

        [data-theme="monocromatico"] .btn-outline-success i {
            color: var(--success-color) !important;
        }

        [data-theme="monocromatico"] .btn-outline-danger i {
            color: var(--danger-color) !important;
        }

        [data-theme="monocromatico"] .btn-outline-warning i {
            color: var(--warning-color) !important;
        }

        [data-theme="monocromatico"] .btn-outline-info i {
            color: var(--info-color) !important;
        }

        /* Elementos activos para tema monocromático */
        [data-theme="monocromatico"] .nav-link.active i {
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .estilo-btn.active i {
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .list-group-item.active i {
            color: white !important;
        }

        [data-theme="monocromatico"] .dropdown-item.active i {
            color: white !important;
        }

        [data-theme="monocromatico"] .pagination .page-item.active .page-link i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] {
            --primary-color: #ffffff;
            --secondary-color: #f0f0f0;
            --accent-color: #e0e0e0;
            --success-color: #ffffff;
            --warning-color: #f0f0f0;
            --danger-color: #ffffff;
            --gradient-primary: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            --gradient-secondary: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
            --gradient-accent: linear-gradient(135deg, #e0e0e0 0%, #ffffff 100%);
            --gradient-success: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
            --gradient-warning: linear-gradient(135deg, #f0f0f0 0%, #e0e0e0 100%);
            --gradient-danger: linear-gradient(135deg, #ffffff 0%, #f0f0f0 100%);
        }

        /* Asegurar que el tema monocromático funcione correctamente en modo claro */
        [data-theme="monocromatico"][data-dark-mode="light"] .card {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .card-header {
            background: var(--bg-tertiary) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .card-body {
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-primary {
            background: var(--gradient-primary) !important;
            border: 2px solid var(--primary-color) !important;
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-primary:hover {
            background: var(--gradient-secondary) !important;
            border-color: var(--secondary-color) !important;
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-outline-primary {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            background: transparent !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-outline-primary:hover {
            background: var(--primary-color) !important;
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .nav-link {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .nav-link:hover {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .nav-link.active {
            background: var(--gradient-primary) !important;
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .navbar-brand {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .form-control {
            background: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .form-select {
            background: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .form-label {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .form-text {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .small {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .text-muted {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .text-primary {
            color: var(--primary-color) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .text-secondary {
            color: var(--text-secondary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .badge {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .badge.bg-primary {
            background: var(--gradient-primary) !important;
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .badge.bg-secondary {
            background: var(--gradient-secondary) !important;
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .alert {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .alert-info {
            background-color: rgba(13, 202, 240, 0.1) !important;
            border-color: rgba(13, 202, 240, 0.2) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .alert-success {
            background-color: rgba(25, 135, 84, 0.1) !important;
            border-color: rgba(25, 135, 84, 0.2) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .alert-warning {
            background-color: rgba(255, 193, 7, 0.1) !important;
            border-color: rgba(255, 193, 7, 0.2) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .alert-danger {
            background-color: rgba(220, 53, 69, 0.1) !important;
            border-color: rgba(220, 53, 69, 0.2) !important;
            color: var(--text-primary) !important;
        }

        /* Iconos específicos para tema monocromático en modo claro */
        [data-theme="monocromatico"][data-dark-mode="light"] .fas,
        [data-theme="monocromatico"][data-dark-mode="light"] .far,
        [data-theme="monocromatico"][data-dark-mode="light"] .fab {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .nav-link i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn i {
            color: inherit !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .card-header i {
            color: var(--primary-color) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .stat-icon i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .navbar-brand i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .badge i {
            color: inherit !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .alert i {
            color: inherit !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .list-group-item i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .table i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .modal-header i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .modal-body i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .breadcrumb i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .pagination i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .form-label i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .form-text i {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .invalid-feedback i {
            color: var(--danger-color) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .valid-feedback i {
            color: var(--success-color) !important;
        }

        /* Botones específicos para tema monocromático en modo claro */
        [data-theme="monocromatico"][data-dark-mode="light"] .btn-primary i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-secondary i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-success i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-danger i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-warning i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-info i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-outline-primary i {
            color: var(--primary-color) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-outline-secondary i {
            color: var(--text-secondary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-outline-success i {
            color: var(--success-color) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-outline-danger i {
            color: var(--danger-color) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-outline-warning i {
            color: var(--warning-color) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-outline-info i {
            color: var(--info-color) !important;
        }

        /* Elementos activos para tema monocromático en modo claro */
        [data-theme="monocromatico"][data-dark-mode="light"] .nav-link.active i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .estilo-btn.active i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .list-group-item.active i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .dropdown-item.active i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .pagination .page-item.active .page-link i {
            color: white !important;
        }

        /* Reglas específicas para tema monocromático en modo claro */
        [data-theme="monocromatico"][data-dark-mode="light"] {
            --text-primary: #000000 !important;
            --text-secondary: #333333 !important;
            --text-muted: #666666 !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] h1,
        [data-theme="monocromatico"][data-dark-mode="light"] h2,
        [data-theme="monocromatico"][data-dark-mode="light"] h3,
        [data-theme="monocromatico"][data-dark-mode="light"] h4,
        [data-theme="monocromatico"][data-dark-mode="light"] h5,
        [data-theme="monocromatico"][data-dark-mode="light"] h6,
        [data-theme="monocromatico"][data-dark-mode="light"] p,
        [data-theme="monocromatico"][data-dark-mode="light"] span,
        [data-theme="monocromatico"][data-dark-mode="light"] div,
        [data-theme="monocromatico"][data-dark-mode="light"] .card-title,
        [data-theme="monocromatico"][data-dark-mode="light"] .card-text,
        [data-theme="monocromatico"][data-dark-mode="light"] .text-muted,
        [data-theme="monocromatico"][data-dark-mode="light"] .small,
        [data-theme="monocromatico"][data-dark-mode="light"] .nav-link,
        [data-theme="monocromatico"][data-dark-mode="light"] .navbar-brand {
            color: #000000 !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn {
            background: #000000 !important;
            color: white !important;
            border: 1px solid #000000 !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn:hover {
            background: #333333 !important;
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn i {
            color: white !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .fas,
        [data-theme="monocromatico"][data-dark-mode="light"] .far,
        [data-theme="monocromatico"][data-dark-mode="light"] .fab {
            color: #000000 !important;
        }

        /* Iconos específicos del dashboard en tema monocromático modo claro */
        [data-theme="monocromatico"][data-dark-mode="light"] .card .fas.fa-calendar,
        [data-theme="monocromatico"][data-dark-mode="light"] .card .fas.fa-users,
        [data-theme="monocromatico"][data-dark-mode="light"] .card .fas.fa-envelope,
        [data-theme="monocromatico"][data-dark-mode="light"] .card .fas.fa-bell,
        [data-theme="monocromatico"][data-dark-mode="light"] .stat-icon .fas.fa-calendar,
        [data-theme="monocromatico"][data-dark-mode="light"] .stat-icon .fas.fa-users,
        [data-theme="monocromatico"][data-dark-mode="light"] .stat-icon .fas.fa-envelope,
        [data-theme="monocromatico"][data-dark-mode="light"] .stat-icon .fas.fa-bell {
            color: #000000 !important;
        }

        /* Iconos específicos del dashboard para tema monocromático */
        [data-theme="monocromatico"] .fas.fa-calendar,
        [data-theme="monocromatico"] .fas.fa-users,
        [data-theme="monocromatico"] .fas.fa-envelope,
        [data-theme="monocromatico"] .fas.fa-bell,
        [data-theme="monocromatico"] .fas.fa-plus,
        [data-theme="monocromatico"] .fas.fa-user-friends,
        [data-theme="monocromatico"] .fas.fa-envelope-open,
        [data-theme="monocromatico"] .fas.fa-calendar-plus,
        [data-theme="monocromatico"] .fas.fa-calendar-alt {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-calendar,
        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-users,
        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-envelope,
        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-bell,
        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-plus,
        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-user-friends,
        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-envelope-open,
        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-calendar-plus,
        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-calendar-alt {
            color: var(--text-primary) !important;
        }

        /* Iconos de configuración para tema monocromático */
        [data-theme="monocromatico"] .fas.fa-cog,
        [data-theme="monocromatico"] .fas.fa-cogs {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-cog,
        [data-theme="monocromatico"][data-dark-mode="light"] .fas.fa-cogs {
            color: var(--text-primary) !important;
        }

        /* Asegurar que todos los iconos del dashboard sean visibles en todos los temas */
        .card .fas,
        .card .far,
        .card .fab {
            color: var(--text-primary) !important;
        }

        .card-header .fas,
        .card-header .far,
        .card-header .fab {
            color: var(--primary-color) !important;
        }

        .stat-icon .fas,
        .stat-icon .far,
        .stat-icon .fab {
            color: white !important;
        }

        /* Iconos específicos del dashboard */
        .fas.fa-calendar,
        .fas.fa-users,
        .fas.fa-envelope,
        .fas.fa-bell,
        .fas.fa-plus,
        .fas.fa-user-friends,
        .fas.fa-envelope-open,
        .fas.fa-calendar-plus,
        .fas.fa-calendar-alt,
        .fas.fa-chart-bar,
        .fas.fa-chart-line,
        .fas.fa-chart-pie {
            color: var(--text-primary) !important;
        }

        [data-theme="minimalista"] {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --accent-color: #ec4899;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --gradient-primary: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            --gradient-secondary: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
            --gradient-accent: linear-gradient(135deg, #ec4899 0%, #6366f1 100%);
        }

        [data-theme="minimalista"][data-dark-mode="light"] {
            --primary-color: #4f46e5;
            --secondary-color: #7c3aed;
            --accent-color: #db2777;
            --gradient-primary: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            --gradient-secondary: linear-gradient(135deg, #7c3aed 0%, #db2777 100%);
            --gradient-accent: linear-gradient(135deg, #db2777 0%, #4f46e5 100%);
        }

        /* Estilos específicos para tema monocromático */
        [data-theme="monocromatico"] .btn-primary {
            background: var(--gradient-primary) !important;
            border: 2px solid var(--primary-color) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .btn-primary:hover {
            background: var(--gradient-secondary) !important;
            border-color: var(--secondary-color) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .btn-secondary {
            background: var(--gradient-secondary) !important;
            border: 2px solid var(--secondary-color) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .btn-outline-primary {
            color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            background: transparent !important;
        }

        [data-theme="monocromatico"] .btn-outline-primary:hover {
            background: var(--primary-color) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .card-header {
            background: var(--gradient-primary) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .nav-link.active {
            background: var(--gradient-primary) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .nav-link.active i {
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .estilo-btn.active {
            background: var(--gradient-primary) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .estilo-btn.active i {
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .badge.bg-primary {
            background: var(--gradient-primary) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .badge.bg-secondary {
            background: var(--gradient-secondary) !important;
            color: var(--bg-primary) !important;
        }

        [data-theme="monocromatico"] .stat-icon .bg-gradient-primary {
            background: var(--gradient-primary) !important;
        }

        [data-theme="monocromatico"] .stat-icon .bg-gradient-secondary {
            background: var(--gradient-secondary) !important;
        }

        [data-theme="monocromatico"] .stat-icon .bg-gradient-accent {
            background: var(--gradient-accent) !important;
        }

        [data-theme="monocromatico"] .gradient-text {
            background: var(--gradient-primary) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        [data-theme="monocromatico"] .gradient-text-secondary {
            background: var(--gradient-secondary) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        [data-theme="monocromatico"] .gradient-text-accent {
            background: var(--gradient-accent) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        /* Asegurar contraste en modo claro para monocromático */
        [data-theme="monocromatico"][data-dark-mode="light"] .btn-primary {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-primary:hover {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-secondary {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .btn-outline-primary:hover {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .card-header {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .nav-link.active {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .nav-link.active i {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .estilo-btn.active {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .estilo-btn.active i {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .badge.bg-primary {
            color: #ffffff !important;
        }

        [data-theme="monocromatico"][data-dark-mode="light"] .badge.bg-secondary {
            color: #ffffff !important;
        }

        /* Asegurar visibilidad en modo oscuro para monocromático */
        [data-theme="monocromatico"] .text-primary {
            color: var(--primary-color) !important;
        }

        [data-theme="monocromatico"] .text-secondary {
            color: var(--secondary-color) !important;
        }

        [data-theme="monocromatico"] .text-muted {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"] .form-label {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .form-text {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"] .small {
            color: var(--text-muted) !important;
        }

        [data-theme="monocromatico"] .alert {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .alert-info {
            background-color: rgba(13, 202, 240, 0.1) !important;
            border-color: rgba(13, 202, 240, 0.2) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .alert-success {
            background-color: rgba(25, 135, 84, 0.1) !important;
            border-color: rgba(25, 135, 84, 0.2) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .alert-warning {
            background-color: rgba(255, 193, 7, 0.1) !important;
            border-color: rgba(255, 193, 7, 0.2) !important;
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .alert-danger {
            background-color: rgba(220, 53, 69, 0.1) !important;
            border-color: rgba(220, 53, 69, 0.2) !important;
            color: var(--text-primary) !important;
        }


        /* Asegurar que todos los textos sean visibles */
        body, .card, .form-control, .btn, .nav-link, .dropdown-item, .alert, .badge, .text-muted, .text-secondary, .text-primary, .form-label, .form-text, .small, .h1, .h2, .h3, .h4, .h5, .h6, .display-1, .display-2, .display-3, .display-4, .display-5, .display-6 {
            color: var(--text-primary) !important;
        }

        /* Asegurar que todos los títulos sean visibles */
        .h1, .h2, .h3, .h4, .h5, .h6 {
            color: var(--text-primary) !important;
        }

        .display-1, .display-2, .display-3, .display-4, .display-5, .display-6 {
            color: var(--text-primary) !important;
        }

        .card-title {
            color: var(--text-primary) !important;
        }

        .card-subtitle {
            color: var(--text-secondary) !important;
        }

        .modal-title {
            color: var(--text-primary) !important;
        }

        .offcanvas-title {
            color: var(--text-primary) !important;
        }

        .accordion-button {
            color: var(--text-primary) !important;
        }

        .accordion-button:not(.collapsed) {
            color: var(--text-primary) !important;
        }

        .navbar-brand {
            color: var(--text-primary) !important;
        }

        .breadcrumb-item {
            color: var(--text-primary) !important;
        }

        .breadcrumb-item.active {
            color: var(--text-muted) !important;
        }

        /* Asegurar que los títulos sean visibles en modo claro */
        [data-dark-mode="light"] .h1,
        [data-dark-mode="light"] .h2,
        [data-dark-mode="light"] .h3,
        [data-dark-mode="light"] .h4,
        [data-dark-mode="light"] .h5,
        [data-dark-mode="light"] .h6 {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .display-1,
        [data-dark-mode="light"] .display-2,
        [data-dark-mode="light"] .display-3,
        [data-dark-mode="light"] .display-4,
        [data-dark-mode="light"] .display-5,
        [data-dark-mode="light"] .display-6 {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .card-title {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .card-subtitle {
            color: var(--text-secondary) !important;
        }

        [data-dark-mode="light"] .modal-title {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .offcanvas-title {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .accordion-button {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .accordion-button:not(.collapsed) {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .navbar-brand {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .breadcrumb-item {
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .breadcrumb-item.active {
            color: var(--text-muted) !important;
        }

        /* Asegurar visibilidad de textos específicos */
        .text-primary {
            color: var(--primary-color) !important;
        }

        .text-secondary {
            color: var(--text-secondary) !important;
        }

        .text-success {
            color: var(--success-color) !important;
        }

        .text-danger {
            color: var(--danger-color) !important;
        }

        .text-warning {
            color: var(--warning-color) !important;
        }

        .text-info {
            color: var(--info-color) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .text-white {
            color: white !important;
        }

        .text-dark {
            color: var(--text-primary) !important;
        }

        .text-light {
            color: var(--text-secondary) !important;
        }

        /* Asegurar contraste en modo claro */
        [data-dark-mode="light"] .text-primary {
            color: var(--primary-color) !important;
        }

        [data-dark-mode="light"] .text-secondary {
            color: #6c757d !important;
        }

        [data-dark-mode="light"] .text-success {
            color: #198754 !important;
        }

        [data-dark-mode="light"] .text-danger {
            color: #dc3545 !important;
        }

        [data-dark-mode="light"] .text-warning {
            color: #f59e0b !important;
        }

        [data-dark-mode="light"] .text-info {
            color: #0dcaf0 !important;
        }

        [data-dark-mode="light"] .text-muted {
            color: #6c757d !important;
        }

        [data-dark-mode="light"] .text-dark {
            color: #000000 !important;
        }

        [data-dark-mode="light"] .text-light {
            color: #f8f9fa !important;
        }

        /* Asegurar visibilidad en elementos específicos */
        .card-title {
            color: var(--text-primary) !important;
        }

        .card-text {
            color: var(--text-primary) !important;
        }

        .list-group-item {
            color: var(--text-primary) !important;
        }

        .table {
            color: var(--text-primary) !important;
        }

        .table th {
            color: var(--text-primary) !important;
        }

        .table td {
            color: var(--text-primary) !important;
        }

        .modal-title {
            color: var(--text-primary) !important;
        }

        .modal-body {
            color: var(--text-primary) !important;
        }

        .dropdown-menu {
            color: var(--text-primary) !important;
        }

        .dropdown-item {
            color: var(--text-primary) !important;
        }

        .dropdown-item:hover {
            color: var(--text-primary) !important;
        }

        .navbar-brand {
            color: var(--text-primary) !important;
        }

        .navbar-nav .nav-link {
            color: var(--text-primary) !important;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link.active {
            color: white !important;
        }

        .breadcrumb {
            color: var(--text-primary) !important;
        }

        .breadcrumb-item {
            color: var(--text-primary) !important;
        }

        .breadcrumb-item.active {
            color: var(--text-muted) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        /* Asegurar contraste perfecto en todos los elementos */
        .form-control {
            background-color: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .form-control:focus {
            background-color: var(--bg-primary) !important;
            border-color: var(--primary-color) !important;
            color: var(--text-primary) !important;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
        }

        .form-select {
            background-color: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .form-select:focus {
            background-color: var(--bg-primary) !important;
            border-color: var(--primary-color) !important;
            color: var(--text-primary) !important;
        }

        .form-check-input {
            background-color: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
        }

        .form-check-input:checked {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .form-range {
            background-color: var(--bg-primary) !important;
        }

        .form-range::-webkit-slider-thumb {
            background-color: var(--primary-color) !important;
        }

        .form-range::-moz-range-thumb {
            background-color: var(--primary-color) !important;
        }

        /* Asegurar contraste en elementos de interfaz */
        .input-group-text {
            background-color: var(--bg-tertiary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .input-group .form-control {
            background-color: var(--bg-primary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .input-group .form-control:focus {
            background-color: var(--bg-primary) !important;
            border-color: var(--primary-color) !important;
            color: var(--text-primary) !important;
        }

        /* Asegurar contraste en elementos de navegación */
        .navbar {
            background-color: var(--bg-secondary) !important;
            border-bottom: 1px solid var(--border-color) !important;
        }

        .navbar-brand {
            color: var(--text-primary) !important;
        }

        .navbar-nav .nav-link {
            color: var(--text-primary) !important;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .navbar-nav .nav-link.active {
            color: white !important;
            background: var(--gradient-primary) !important;
        }

        .navbar-toggler {
            border-color: var(--border-color) !important;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.85%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
        }

        /* Asegurar contraste en elementos de contenido */
        .list-group-item {
            background-color: var(--bg-secondary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .list-group-item:hover {
            background-color: var(--bg-tertiary) !important;
            color: var(--text-primary) !important;
        }

        .list-group-item.active {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }

        .table {
            background-color: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        .table th {
            background-color: var(--bg-tertiary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .table td {
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: var(--bg-primary) !important;
        }

        .table-hover tbody tr:hover {
            background-color: var(--bg-tertiary) !important;
        }

        /* Asegurar contraste en elementos de estado */
        .alert {
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .alert-info {
            background-color: rgba(13, 202, 240, 0.1) !important;
            border-color: rgba(13, 202, 240, 0.2) !important;
            color: var(--text-primary) !important;
        }

        .alert-success {
            background-color: rgba(25, 135, 84, 0.1) !important;
            border-color: rgba(25, 135, 84, 0.2) !important;
            color: var(--text-primary) !important;
        }

        .alert-warning {
            background-color: rgba(255, 193, 7, 0.1) !important;
            border-color: rgba(255, 193, 7, 0.2) !important;
            color: var(--text-primary) !important;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1) !important;
            border-color: rgba(220, 53, 69, 0.2) !important;
            color: var(--text-primary) !important;
        }

        /* Asegurar contraste en elementos de navegación secundaria */
        .breadcrumb {
            background-color: var(--bg-tertiary) !important;
        }

        .breadcrumb-item {
            color: var(--text-primary) !important;
        }

        .breadcrumb-item.active {
            color: var(--text-muted) !important;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            color: var(--text-muted) !important;
        }

        /* Asegurar contraste en elementos de formulario */
        .form-label {
            color: var(--text-primary) !important;
        }

        .form-text {
            color: var(--text-muted) !important;
        }

        .invalid-feedback {
            color: var(--danger-color) !important;
        }

        .valid-feedback {
            color: var(--success-color) !important;
        }

        .is-invalid {
            border-color: var(--danger-color) !important;
        }

        .is-valid {
            border-color: var(--success-color) !important;
        }

        /* Asegurar contraste en elementos de estado */
        .badge {
            color: white !important;
        }

        .badge.bg-primary {
            background-color: var(--primary-color) !important;
        }

        .badge.bg-secondary {
            background-color: var(--text-secondary) !important;
        }

        .badge.bg-success {
            background-color: var(--success-color) !important;
        }

        .badge.bg-danger {
            background-color: var(--danger-color) !important;
        }

        .badge.bg-warning {
            background-color: var(--warning-color) !important;
            color: var(--text-primary) !important;
        }

        .badge.bg-info {
            background-color: var(--info-color) !important;
        }

        /* Asegurar contraste en elementos de navegación desplegable */
        .dropdown-menu {
            background-color: var(--bg-secondary) !important;
            border-color: var(--border-color) !important;
        }

        .dropdown-item {
            color: var(--text-primary) !important;
        }

        .dropdown-item:hover {
            background-color: var(--bg-tertiary) !important;
            color: var(--text-primary) !important;
        }

        .dropdown-item.active {
            background-color: var(--primary-color) !important;
            color: white !important;
        }

        .dropdown-divider {
            border-color: var(--border-color) !important;
        }

        /* Asegurar contraste en elementos de paginación */
        .pagination .page-link {
            background-color: var(--bg-secondary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .pagination .page-link:hover {
            background-color: var(--bg-tertiary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }

        .pagination .page-item.disabled .page-link {
            background-color: var(--bg-tertiary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-muted) !important;
        }

        .text-secondary {
            color: var(--text-secondary) !important;
        }

        .form-control::placeholder {
            color: var(--text-muted) !important;
        }

        .form-control:focus {
            color: var(--text-primary) !important;
        }

        .dropdown-menu {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
        }

        .dropdown-item {
            color: var(--text-primary) !important;
        }

        .dropdown-item:hover {
            background: var(--bg-tertiary) !important;
            color: var(--text-primary) !important;
        }

        .alert {
            color: var(--text-primary) !important;
        }

        .alert-danger {
            background: rgba(255, 107, 107, 0.1) !important;
            border-left: 4px solid #ff6b6b !important;
            color: #ff6b6b !important;
        }

        .alert-success {
            background: rgba(67, 233, 123, 0.1) !important;
            border-left: 4px solid #43e97b !important;
            color: #43e97b !important;
        }

        .alert-warning {
            background: rgba(250, 112, 154, 0.1) !important;
            border-left: 4px solid #fa709a !important;
            color: #fa709a !important;
        }

        .alert-info {
            background: rgba(79, 172, 254, 0.1) !important;
            border-left: 4px solid #4facfe !important;
            color: #4facfe !important;
        }

        .badge {
            color: white !important;
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

        .table {
            color: var(--text-primary) !important;
        }

        .table th {
            color: var(--text-primary) !important;
        }

        .table td {
            color: var(--text-primary) !important;
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

        .btn-close {
            filter: invert(1) !important;
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

        .input-group-text {
            background: var(--bg-tertiary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .list-group-item {
            background: var(--bg-secondary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .list-group-item:hover {
            background: var(--bg-tertiary) !important;
        }

        .pagination .page-link {
            background: var(--bg-secondary) !important;
            border-color: var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .pagination .page-link:hover {
            background: var(--bg-tertiary) !important;
            color: var(--text-primary) !important;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
            color: white !important;
        }

        .breadcrumb {
            background: var(--bg-tertiary) !important;
        }

        .breadcrumb-item a {
            color: var(--text-primary) !important;
        }

        .breadcrumb-item.active {
            color: var(--text-muted) !important;
        }

        .progress {
            background: var(--bg-tertiary) !important;
        }

        .progress-bar {
            background: var(--primary-color) !important;
        }

        .spinner-border {
            color: var(--primary-color) !important;
        }

        .spinner-grow {
            color: var(--primary-color) !important;
        }

        .toast {
            background: var(--bg-secondary) !important;
            color: var(--text-primary) !important;
        }

        .toast-header {
            background: var(--bg-tertiary) !important;
            border-bottom: 1px solid var(--border-color) !important;
        }

        .tooltip {
            background: var(--bg-primary) !important;
            color: var(--text-primary) !important;
        }

        .popover {
            background: var(--bg-secondary) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .popover-header {
            background: var(--bg-tertiary) !important;
            border-bottom: 1px solid var(--border-color) !important;
            color: var(--text-primary) !important;
        }

        .popover-body {
            color: var(--text-primary) !important;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-primary);
            font-size: var(--font-size-base);
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Header fijo moderno */
        .header-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px var(--shadow);
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
            min-height: 70px;
            gap: 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .nav-main {
            display: flex;
            align-items: center;
        }

        .nav-links {
            display: flex;
            align-items: center;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0.5rem;
        }

        .nav-links li {
            display: flex;
            align-items: center;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.6rem 1rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-weight: 500;
            text-decoration: none;
            color: var(--text-primary);
            position: relative;
            min-height: 40px;
        }

        .nav-link:hover {
            background: var(--bg-tertiary);
            transform: translateY(-2px);
            color: var(--text-primary);
        }

        .nav-link.active {
            background: var(--gradient-primary);
            color: white !important;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .nav-link.active i {
            color: white !important;
        }

        .nav-link i {
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        /* Estilos Rápidos Flotantes */
        .estilos-rapidos-flotantes {
            position: fixed;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .estilo-btn {
            width: 50px;
            height: 50px;
            border: 2px solid var(--border-color);
            border-radius: 50%;
            background: var(--bg-secondary);
            color: white;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .estilo-btn:hover {
            transform: scale(1.1);
            border-color: var(--primary-color);
            background: var(--primary-color);
            color: white;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .estilo-btn i {
            color: white !important;
        }

        /* Excepción para tema monocromático - iconos con contraste apropiado */
        [data-theme="monocromatico"][data-dark-mode="light"] .estilo-btn i {
            color: var(--text-primary) !important;
        }

        [data-theme="monocromatico"] .estilo-btn i {
            color: white !important;
        }

        .estilo-btn.active {
            border-color: var(--primary-color);
            background: var(--gradient-primary);
            color: white !important;
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
            transform: scale(1.1);
        }

        .estilo-btn.active i {
            color: white !important;
        }

        @media (max-width: 768px) {
            .estilos-rapidos-flotantes {
                right: 10px;
                gap: 8px;
            }
            
            .estilo-btn {
                width: 40px;
                height: 40px;
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .estilos-rapidos-flotantes {
                right: 5px;
                gap: 6px;
            }
            
            .estilo-btn {
                width: 35px;
                height: 35px;
                font-size: 12px;
            }
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-primary);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            overflow: hidden;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: var(--border-radius);
        }

        .logo-text {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Navegación principal */
        .nav-main {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            list-style: none;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-sm);
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: var(--bg-tertiary);
        }

        .nav-link.active {
            color: white !important;
            background: var(--gradient-primary);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .nav-link.active i {
            color: white !important;
        }

        /* Botones modernos */
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: var(--transition);
            cursor: pointer;
            font-size: 0.9rem;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: var(--gradient-secondary);
            color: white;
            box-shadow: 0 4px 15px rgba(240, 147, 251, 0.3);
        }

        .btn-accent {
            background: var(--gradient-accent);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }

        .btn-success {
            background: var(--gradient-success);
            color: white;
            box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);
        }

        .btn-warning {
            background: var(--gradient-warning);
            color: white;
            box-shadow: 0 4px 15px rgba(250, 112, 154, 0.3);
        }

        .btn-danger {
            background: var(--gradient-danger);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }

        /* Gradientes para títulos */
        .gradient-text {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-text-secondary {
            background: var(--gradient-secondary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-text-accent {
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Asegurar que los títulos sean visibles en modo claro */
        [data-dark-mode="light"] .gradient-text {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .gradient-text-secondary {
            background: var(--gradient-secondary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: var(--text-primary) !important;
        }

        [data-dark-mode="light"] .gradient-text-accent {
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            color: var(--text-primary) !important;
        }

        /* Fallback para navegadores que no soportan background-clip */
        @supports not (-webkit-background-clip: text) {
            .gradient-text {
                color: var(--primary-color) !important;
                background: none !important;
            }

            .gradient-text-secondary {
                color: var(--secondary-color) !important;
                background: none !important;
            }

            .gradient-text-accent {
                color: var(--accent-color) !important;
                background: none !important;
            }

            [data-dark-mode="light"] .gradient-text {
                color: var(--primary-color) !important;
                background: none !important;
            }

            [data-dark-mode="light"] .gradient-text-secondary {
                color: var(--secondary-color) !important;
                background: none !important;
            }

            [data-dark-mode="light"] .gradient-text-accent {
                color: var(--accent-color) !important;
                background: none !important;
            }
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--text-primary);
        }

        .btn-outline-primary:hover {
            background: var(--gradient-primary);
            color: white;
            border-color: transparent;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 0.8rem;
        }

        .btn-lg {
            padding: 16px 32px;
            font-size: 1.1rem;
        }

        /* Contenido principal */
        .main-content {
            margin-top: 80px;
            min-height: calc(100vh - 80px);
            padding: 2rem;
        }

        .container-fluid {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Cards modernas */
        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: 0 8px 32px var(--shadow);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 48px var(--shadow);
        }

        .card-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            background: var(--bg-tertiary);
            border-top: 1px solid var(--border-color);
            padding: 1rem 1.5rem;
        }

        /* Formularios */
        .form-control {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
            color: var(--text-primary);
            padding: 12px 16px;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .form-control:focus {
            background: var(--bg-secondary);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }


        /* Notificaciones */
        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--gradient-danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                padding: 1rem;
            }

            .nav-main {
                gap: 1rem;
            }

            .nav-links {
                gap: 1rem;
            }

            .nav-link {
                padding: 0.5rem;
                font-size: 0.9rem;
            }

            .main-content {
                padding: 1rem;
            }

            .theme-selector {
                right: 10px;
                top: auto;
                bottom: 20px;
                transform: none;
                flex-direction: row;
                flex-wrap: wrap;
                max-width: 200px;
            }

            .theme-btn {
                width: 40px;
                height: 40px;
            }
        }

        @media (max-width: 576px) {
            .nav-links {
                display: none;
            }

            .main-content {
                padding: 0.5rem;
            }

            .theme-selector {
                right: 5px;
                bottom: 5px;
                max-width: 150px;
            }

            .theme-btn {
                width: 35px;
                height: 35px;
            }
        }

        /* Animaciones */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <!-- Header fijo moderno -->
    <header class="header-fixed">
        <div class="header-content">
            <a href="{{ route('dashboard') }}" class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('logo.png') }}" alt="Eventum Logo" class="logo-img">
                </div>
                <div class="logo-text">Eventum</div>
            </a>


            <nav class="nav-main">
                <ul class="nav-links">
                    <li><a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i>
                        Inicio
                    </a></li>
                    <li><a href="{{ route('eventos.index') }}" class="nav-link {{ request()->routeIs('eventos.*') ? 'active' : '' }}">
                        <i class="fas fa-calendar"></i>
                        Eventos
                    </a></li>
                    <li><a href="{{ route('invitaciones.index') }}" class="nav-link {{ request()->routeIs('invitaciones.*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        Invitaciones
                    </a></li>
                    <li><a href="{{ route('notificaciones.index') }}" class="nav-link {{ request()->routeIs('notificaciones.*') ? 'active' : '' }}">
                        <i class="fas fa-bell"></i>
                        Notificaciones
                        @if(Auth::check() && Auth::user()->notificaciones()->where('leida', false)->count() > 0)
                            <span class="notification-badge">{{ Auth::user()->notificaciones()->where('leida', false)->count() }}</span>
                        @endif
                    </a></li>
                    <li><a href="{{ route('reportes.index') }}" class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                        <i class="fas fa-flag"></i>
                        Reportes
                    </a></li>
                    <li><a href="{{ route('lista.index') }}" class="nav-link {{ request()->routeIs('lista.*') ? 'active' : '' }}">
                        <i class="fas fa-list"></i>
                        Lista
                    </a></li>
                    <li><a href="{{ route('configuracion.index') }}" class="nav-link {{ request()->routeIs('configuracion.*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        Configuración
                    </a></li>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-primary btn-sm" onclick="toggleDarkMode()">
                        <i class="fas fa-moon" id="darkModeIcon"></i>
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i>
                            {{ Auth::user()->nombre_usuario ?? 'Usuario' }}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('usuarios.perfil') }}">
                                <i class="fas fa-user me-2"></i>Mi Perfil
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('reportes.index') }}">
                                <i class="fas fa-flag me-2"></i>Mis Reportes
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('lista.index') }}">
                                <i class="fas fa-list me-2"></i>Lista de Cosas
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('configuracion.index') }}">
                                <i class="fas fa-cog me-2"></i>Configuración
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" onclick="cerrarSesion()">
                                <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                            </a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>

        <!-- Estilos Rápidos Flotantes -->
        <div class="estilos-rapidos-flotantes">
            <button class="estilo-btn" data-theme="minimalista" title="Minimalista">
                <i class="fas fa-circle"></i>
            </button>
            <button class="estilo-btn" data-theme="cyber" title="Cyber">
                <i class="fas fa-shield-alt"></i>
            </button>
            <button class="estilo-btn" data-theme="neon" title="Neon">
                <i class="fas fa-bolt"></i>
            </button>
            <button class="estilo-btn" data-theme="futurista" title="Futurista">
                <i class="fas fa-rocket"></i>
            </button>
        </div>

    <!-- Contenido principal -->
    <main class="main-content">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    @yield('styles')
    @yield('scripts')


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle dark mode
        function toggleDarkMode() {
            const currentMode = document.documentElement.getAttribute('data-dark-mode');
            const newMode = currentMode === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-dark-mode', newMode);
            
            const icon = document.getElementById('darkModeIcon');
            icon.className = newMode === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            
            localStorage.setItem('darkMode', newMode);
            
            // Actualizar configuración en el servidor
            updateUserPreference('modo_oscuro', newMode);
        }

        function changeTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            localStorage.setItem('selectedTheme', theme);
            updateUserPreference('tema', theme);
            
            // Actualizar botones activos
            document.querySelectorAll('.estilo-btn').forEach(b => b.classList.remove('active'));
            document.querySelector(`[data-theme="${theme}"]`).classList.add('active');
        }

        function updateUserPreference(key, value) {
            fetch('/configuracion/actualizar', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    [key]: value
                })
            }).catch(error => console.log('Error updating preference:', error));
        }

        // Estilos rápidos
        document.querySelectorAll('.estilo-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const theme = this.dataset.theme;
                changeTheme(theme);
                
                // Actualizar botones activos
                document.querySelectorAll('.estilo-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Theme selector
        document.querySelectorAll('.theme-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const theme = this.dataset.theme;
                changeTheme(theme);
                
                document.querySelectorAll('.theme-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Load saved preferences
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('selectedTheme') || 'minimalista';
            const savedDarkMode = localStorage.getItem('darkMode');
            
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
                // Marcar botón activo
                document.querySelectorAll('.estilo-btn').forEach(b => b.classList.remove('active'));
                const activeBtn = document.querySelector(`[data-theme="${savedTheme}"]`);
                if (activeBtn) {
                    activeBtn.classList.add('active');
                }
            }
            
            if (savedDarkMode) {
                document.documentElement.setAttribute('data-dark-mode', savedDarkMode);
                const icon = document.getElementById('darkModeIcon');
                if (icon) {
                    icon.className = savedDarkMode === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                }
            }
        });

        function cerrarSesion() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                window.location.href = '/logout';
            }
        }
    </script>
</body>
</html>
