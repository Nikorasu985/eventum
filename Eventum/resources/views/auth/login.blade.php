<!DOCTYPE html>
<html lang="es" data-theme="futurista" data-dark-mode="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - Eventum</title>
    
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #f093fb;
            --success-color: #43e97b;
            --warning-color: #fa709a;
            --danger-color: #ff6b6b;
            
            --bg-primary: #0a0a0a;
            --bg-secondary: #1a1a1a;
            --bg-tertiary: #2a2a2a;
            --text-primary: #ffffff;
            --text-secondary: #e0e0e0;
            --text-muted: #a0a0a0;
            --border-color: #333333;
            --shadow: rgba(0, 0, 0, 0.3);
            
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            
            --font-primary: 'Inter', sans-serif;
            --font-heading: 'Space Grotesk', sans-serif;
            --border-radius: 12px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-dark-mode="light"] {
            --bg-primary: #ffffff;
            --bg-secondary: #f8f9fa;
            --bg-tertiary: #e9ecef;
            --text-primary: #212529;
            --text-secondary: #495057;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --shadow: rgba(0, 0, 0, 0.1);
        }

        /* Asegurar visibilidad en todos los elementos */
        body, .card, .form-control, .btn, .alert, .form-label, .form-text, .small, .h1, .h2, .h3, .h4, .h5, .h6, .display-1, .display-2, .display-3, .display-4, .display-5, .display-6 {
            color: var(--text-primary) !important;
        }

        .text-muted {
            color: var(--text-muted) !important;
        }

        .form-control::placeholder {
            color: var(--text-muted) !important;
        }

        .form-control:focus {
            color: var(--text-primary) !important;
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-primary);
            background: var(--bg-primary);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-primary);
            opacity: 0.1;
            z-index: -1;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .login-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: 0 20px 60px var(--shadow);
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: white;
            font-size: 2rem;
            overflow: hidden;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 50%;
        }

        .logo-text {
            font-family: var(--font-heading);
            font-weight: 800;
            font-size: 2rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-control {
            background: var(--bg-tertiary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            color: var(--text-primary);
            padding: 12px 16px;
            transition: var(--transition);
            font-size: 0.9rem;
        }

        .form-control:focus {
            background: var(--bg-primary);
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

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
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

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group .form-control {
            padding-left: 3rem;
        }

        .input-group-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            z-index: 3;
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
            border-left: 4px solid #ff6b6b;
        }

        .alert-success {
            background: rgba(67, 233, 123, 0.1);
            color: #43e97b;
            border-left: 4px solid #43e97b;
        }

        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .theme-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 2px solid var(--border-color);
            background: var(--bg-secondary);
            color: var(--text-primary);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .theme-btn:hover {
            transform: scale(1.1);
            border-color: var(--primary-color);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
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

        @media (max-width: 576px) {
            .login-container {
                padding: 1rem;
            }
            
            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Toggle de tema -->
    <div class="theme-toggle">
        <button class="theme-btn" onclick="toggleDarkMode()" title="Cambiar tema">
            <i class="fas fa-moon" id="themeIcon"></i>
        </button>
    </div>

    <div class="login-container">
        <div class="login-card fade-in">
            <div class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('logo.png') }}" alt="Eventum Logo" class="logo-img">
                </div>
                <div class="logo-text">Eventum</div>
                <p class="text-muted">Inicia sesión en tu cuenta</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf
                
                <div class="input-group">
                    <i class="fas fa-envelope input-group-icon"></i>
                    <input type="email" 
                           class="form-control @error('correo') is-invalid @enderror" 
                           name="correo" 
                           id="correo"
                           value="{{ old('correo') }}" 
                           placeholder="Correo electrónico"
                           required 
                           autofocus
                           autocomplete="email">
                    <div class="invalid-feedback" id="correo-error"></div>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock input-group-icon"></i>
                    <input type="password" 
                           class="form-control @error('contraseña') is-invalid @enderror" 
                           name="contraseña" 
                           id="contraseña"
                           placeholder="Contraseña"
                           required
                           autocomplete="current-password">
                    <div class="invalid-feedback" id="contraseña-error"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">
                            Recordarme
                        </label>
                    </div>
                    <div id="forgotPasswordLink" style="display: none;">
                        <a href="#" class="text-decoration-none" style="color: var(--primary-color);">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 pulse" id="submitBtn">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    <span id="btnText">Iniciar Sesión</span>
                    <div class="spinner-border spinner-border-sm d-none" id="spinner" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </button>

                <div class="text-center">
                    <p class="text-muted mb-0">¿No tienes una cuenta?</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary w-100 mt-2">
                        <i class="fas fa-user-plus me-2"></i>
                        Crear Cuenta
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleDarkMode() {
            const currentMode = document.documentElement.getAttribute('data-dark-mode');
            const newMode = currentMode === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-dark-mode', newMode);
            
            const icon = document.getElementById('themeIcon');
            icon.className = newMode === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            
            localStorage.setItem('darkMode', newMode);
        }

        // Contador de intentos fallidos
        let failedAttempts = 0;

        // Validación en tiempo real
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function validatePassword(password) {
            return password.length >= 6;
        }

        function showError(inputId, message) {
            const input = document.getElementById(inputId);
            const errorDiv = document.getElementById(inputId + '-error');
            
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            errorDiv.textContent = message;
        }

        function showSuccess(inputId) {
            const input = document.getElementById(inputId);
            const errorDiv = document.getElementById(inputId + '-error');
            
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            errorDiv.textContent = '';
        }

        function clearValidation(inputId) {
            const input = document.getElementById(inputId);
            const errorDiv = document.getElementById(inputId + '-error');
            
            input.classList.remove('is-invalid', 'is-valid');
            errorDiv.textContent = '';
        }

        function validateForm() {
            const correo = document.getElementById('correo').value.trim();
            const contraseña = document.getElementById('contraseña').value;
            let isValid = true;

            // Validar correo
            if (!correo) {
                showError('correo', 'El correo electrónico es requerido');
                isValid = false;
            } else if (!validateEmail(correo)) {
                showError('correo', 'Ingresa un correo electrónico válido');
                isValid = false;
            } else {
                showSuccess('correo');
            }

            // Validar contraseña
            if (!contraseña) {
                showError('contraseña', 'La contraseña es requerida');
                isValid = false;
            } else if (!validatePassword(contraseña)) {
                showError('contraseña', 'La contraseña debe tener al menos 6 caracteres');
                isValid = false;
            } else {
                showSuccess('contraseña');
            }

            return isValid;
        }

        function showForgotPasswordLink() {
            const forgotLink = document.getElementById('forgotPasswordLink');
            forgotLink.style.display = 'block';
            forgotLink.style.animation = 'fadeIn 0.5s ease-in';
        }

        // Event listeners para validación en tiempo real
        document.addEventListener('DOMContentLoaded', function() {
            const savedDarkMode = localStorage.getItem('darkMode');
            
            if (savedDarkMode) {
                document.documentElement.setAttribute('data-dark-mode', savedDarkMode);
                const icon = document.getElementById('themeIcon');
                icon.className = savedDarkMode === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }

            // Verificar intentos fallidos desde el servidor
            const serverAttempts = {{ session('login_attempts', 0) }};
            failedAttempts = serverAttempts;
            if (failedAttempts >= 2) {
                showForgotPasswordLink();
            }

            // Validación en tiempo real
            const correoInput = document.getElementById('correo');
            const contraseñaInput = document.getElementById('contraseña');
            const form = document.getElementById('loginForm');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');

            correoInput.addEventListener('blur', function() {
                const value = this.value.trim();
                if (value) {
                    if (validateEmail(value)) {
                        showSuccess('correo');
                    } else {
                        showError('correo', 'Ingresa un correo electrónico válido');
                    }
                } else {
                    clearValidation('correo');
                }
            });

            contraseñaInput.addEventListener('blur', function() {
                const value = this.value;
                if (value) {
                    if (validatePassword(value)) {
                        showSuccess('contraseña');
                    } else {
                        showError('contraseña', 'La contraseña debe tener al menos 6 caracteres');
                    }
                } else {
                    clearValidation('contraseña');
                }
            });

            // Limpiar validación al escribir
            correoInput.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    clearValidation('correo');
                }
            });

            contraseñaInput.addEventListener('input', function() {
                if (this.classList.contains('is-invalid')) {
                    clearValidation('contraseña');
                }
            });

            // Validación al enviar formulario
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (validateForm()) {
                    // Mostrar loading
                    submitBtn.disabled = true;
                    btnText.textContent = 'Iniciando sesión...';
                    spinner.classList.remove('d-none');
                    
                    // Enviar formulario
                    setTimeout(() => {
                        form.submit();
                    }, 1000);
                } else {
                    // Incrementar contador de intentos fallidos
                    failedAttempts++;
                    
                    // Mostrar enlace de olvidar contraseña después de 2 intentos
                    if (failedAttempts >= 2) {
                        showForgotPasswordLink();
                    }
                }
            });
        });
    </script>
</body>
</html>