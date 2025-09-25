<!DOCTYPE html>
<html lang="es" data-theme="futurista" data-dark-mode="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrarse - Eventum</title>
    
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

        .strength-text {
            color: var(--text-muted) !important;
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

        .register-container {
            width: 100%;
            max-width: 500px;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .register-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: 0 20px 60px var(--shadow);
            padding: 3rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .register-card::before {
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

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.8rem;
            position: relative;
            z-index: 10;
            clear: both;
        }

        .strength-bar {
            height: 8px;
            background: var(--bg-tertiary);
            border-radius: 4px;
            overflow: hidden;
            margin-top: 0.5rem;
            border: 1px solid var(--border-color);
            width: 100%;
        }

        .strength-fill {
            height: 100%;
            transition: var(--transition);
            border-radius: 3px;
            width: 0%;
        }

        .strength-weak { background: var(--danger-color); width: 25%; }
        .strength-fair { background: var(--warning-color); width: 50%; }
        .strength-good { background: var(--accent-color); width: 75%; }
        .strength-strong { background: var(--success-color); width: 100%; }

        #strengthText {
            font-size: 0.85rem;
            font-weight: 500;
            min-height: 1.2rem;
            display: block;
            margin-top: 0.5rem;
            color: var(--text-muted) !important;
        }

        @media (max-width: 576px) {
            .register-container {
                padding: 1rem;
            }
            
            .register-card {
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

    <div class="register-container">
        <div class="register-card fade-in">
            <div class="logo">
                <div class="logo-icon">
                    <img src="{{ asset('logo.png') }}" alt="Eventum Logo" class="logo-img">
                </div>
                <div class="logo-text">Eventum</div>
                <p class="text-muted">Crea tu cuenta para comenzar</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <i class="fas fa-user input-group-icon"></i>
                            <input type="text" 
                                   class="form-control @error('nombre_usuario') is-invalid @enderror" 
                                   name="nombre_usuario" 
                                   value="{{ old('nombre_usuario') }}" 
                                   placeholder="Nombre de usuario"
                                   required 
                                   autofocus>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <i class="fas fa-envelope input-group-icon"></i>
                            <input type="email" 
                                   class="form-control @error('correo') is-invalid @enderror" 
                                   name="correo" 
                                   value="{{ old('correo') }}" 
                                   placeholder="Correo electrónico"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock input-group-icon"></i>
                    <input type="password" 
                           class="form-control @error('contraseña') is-invalid @enderror" 
                           name="contraseña" 
                           id="password"
                           placeholder="Contraseña"
                           required
                           onkeyup="checkPasswordStrength(this.value)">
                    <div class="password-strength mt-3">
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthBar"></div>
                        </div>
                        <small id="strengthText" class="text-muted d-block mt-2"></small>
                    </div>
                </div>

                <div class="input-group">
                    <i class="fas fa-lock input-group-icon"></i>
                    <input type="password" 
                           class="form-control @error('contraseña_confirmation') is-invalid @enderror" 
                           name="contraseña_confirmation" 
                           placeholder="Confirmar contraseña"
                           required>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                    <label class="form-check-label" for="terms">
                        Acepto los <a href="#" class="text-decoration-none" style="color: var(--primary-color);">términos y condiciones</a>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3 pulse">
                    <i class="fas fa-user-plus me-2"></i>
                    Crear Cuenta
                </button>

                <div class="text-center">
                    <p class="text-muted mb-0">¿Ya tienes una cuenta?</p>
                    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 mt-2">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Iniciar Sesión
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

        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            let strength = 0;
            let strengthLabel = '';
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            switch (strength) {
                case 0:
                case 1:
                    strengthBar.className = 'strength-fill strength-weak';
                    strengthLabel = 'Muy débil';
                    break;
                case 2:
                    strengthBar.className = 'strength-fill strength-fair';
                    strengthLabel = 'Débil';
                    break;
                case 3:
                    strengthBar.className = 'strength-fill strength-good';
                    strengthLabel = 'Buena';
                    break;
                case 4:
                case 5:
                    strengthBar.className = 'strength-fill strength-strong';
                    strengthLabel = 'Muy fuerte';
                    break;
            }
            
            if (password.length > 0) {
                strengthText.textContent = strengthLabel;
            } else {
                strengthText.textContent = '';
            }
        }

        // Load saved preferences
        document.addEventListener('DOMContentLoaded', function() {
            const savedDarkMode = localStorage.getItem('darkMode');
            
            if (savedDarkMode) {
                document.documentElement.setAttribute('data-dark-mode', savedDarkMode);
                const icon = document.getElementById('themeIcon');
                icon.className = savedDarkMode === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
            }
        });
    </script>
</body>
</html>
