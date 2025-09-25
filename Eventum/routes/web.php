<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\InvitacionController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ListaController;

Route::get('/', function () {
    if (session('usuario_id')) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware(['simple.auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/estadisticas', [DashboardController::class, 'obtenerEstadisticas'])->name('dashboard.estadisticas');
    
    // Eventos
    Route::resource('eventos', EventoController::class);
    Route::post('/eventos/unirse-codigo', [EventoController::class, 'unirsePorCodigo'])->name('eventos.unirse-codigo');
    Route::post('/eventos/{id}/cosas-por-llevar', [EventoController::class, 'agregarCosaPorLlevar'])->name('eventos.agregar-cosa');
    Route::put('/eventos/{id}/cosas-por-llevar/{cosaId}', [EventoController::class, 'actualizarCosaPorLlevar'])->name('eventos.actualizar-cosa');
    
    // Usuarios
    Route::get('/usuarios/perfil', [UsuarioController::class, 'perfil'])->name('usuarios.perfil');
    Route::put('/usuarios/perfil', [UsuarioController::class, 'actualizarPerfil'])->name('usuarios.actualizar-perfil');
    
    // Invitaciones
    Route::get('/invitaciones', [InvitacionController::class, 'index'])->name('invitaciones.index');
    Route::post('/invitaciones/{id}/aceptar', [InvitacionController::class, 'aceptar'])->name('invitaciones.aceptar');
    Route::post('/invitaciones/{id}/rechazar', [InvitacionController::class, 'rechazar'])->name('invitaciones.rechazar');
    
    // Notificaciones
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');
    Route::post('/notificaciones/{id}/marcar-leida', [NotificacionController::class, 'marcarLeida'])->name('notificaciones.marcar-leida');
    Route::post('/notificaciones/marcar-todas-leidas', [NotificacionController::class, 'marcarTodasLeidas'])->name('notificaciones.marcar-todas-leidas');
    
    // Configuración
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');
    Route::put('/configuracion', [ConfiguracionController::class, 'actualizar'])->name('configuracion.actualizar');
    
    // Reportes
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::post('/reportes', [ReporteController::class, 'crear'])->name('reportes.crear');
    
    // Lista de cosas por llevar
    Route::get('/lista', [ListaController::class, 'index'])->name('lista.index');
    Route::post('/lista', [ListaController::class, 'crear'])->name('lista.crear');
    Route::post('/lista/{id}/actualizar', [ListaController::class, 'actualizar'])->name('lista.actualizar');
    Route::post('/lista/{id}/eliminar', [ListaController::class, 'eliminar'])->name('lista.eliminar');
});

// Rutas de autenticación (si no tienes Laravel Breeze instalado)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'correo' => 'required|email',
        'contraseña' => 'required|string'
    ]);

    $usuario = \App\Models\Usuario::where('correo', $request->correo)->first();
    
    if ($usuario && \Illuminate\Support\Facades\Hash::check($request->contraseña, $usuario->contraseña)) {
        session(['usuario_id' => $usuario->id_usuario]);
        session()->forget('login_attempts');
        return redirect()->route('dashboard');
    }

    // Incrementar intentos fallidos
    $attempts = session('login_attempts', 0) + 1;
    session(['login_attempts' => $attempts]);

    return back()->withErrors(['correo' => 'Credenciales incorrectas']);
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'nombre_usuario' => 'required|string|max:100|unique:usuarios,nombre_usuario',
        'correo' => 'required|email|max:100|unique:usuarios,correo',
        'contraseña' => 'required|string|min:8|confirmed',
        'terms' => 'required'
    ]);

    $usuario = new \App\Models\Usuario();
    $usuario->nombre_usuario = $request->nombre_usuario;
    $usuario->correo = $request->correo;
    $usuario->contraseña = \Illuminate\Support\Facades\Hash::make($request->contraseña);
    $usuario->id_rol_sistema = 2; // Usuario regular
    $usuario->save();
    
    // Crear configuración por defecto
    $configuracion = new \App\Models\ConfiguracionUsuario();
    $configuracion->id_usuario = $usuario->id_usuario;
    $configuracion->tema = 'minimalista';
    $configuracion->modo_oscuro = 'dark';
    $configuracion->idioma = 'es';
    $configuracion->zona_horaria = 'America/Mexico_City';
    $configuracion->animaciones_habilitadas = true;
    $configuracion->tamaño_fuente = 16;
    $configuracion->tipo_fuente = 'Inter';
    $configuracion->save();
    
    session(['usuario_id' => $usuario->id_usuario]);
    return redirect()->route('dashboard')->with('success', '¡Cuenta creada exitosamente!');
});

Route::post('/logout', function () {
    session()->forget('usuario_id');
    return redirect()->route('login');
})->name('logout');

Route::get('/logout', function () {
    session()->forget('usuario_id');
    return redirect()->route('login');
})->name('logout.get');
