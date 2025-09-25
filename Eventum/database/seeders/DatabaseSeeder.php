<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Evento;
use App\Models\ConfiguracionUsuario;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Ejecutar seeders de lookup tables en orden
        $this->call([
            RolSistemaSeeder::class,
            TipoPresupuestoSeeder::class,
            RolEventoSeeder::class,
            TipoSolicitudSeeder::class,
            EstadoSolicitudSeeder::class,
            EstadoParticipacionSeeder::class,
            TipoNotificacionSeeder::class,
        ]);

        // Usuario de prueba - Administrador
        Usuario::create([
            'nombre_usuario' => 'admin',
            'correo' => 'admin@eventum.com',
            'contraseña' => Hash::make('password'),
            'id_rol_sistema' => 1, // Administrador
        ]);

        // Usuario regular de prueba
        Usuario::create([
            'nombre_usuario' => 'usuario',
            'correo' => 'usuario@eventum.com',
            'contraseña' => Hash::make('password'),
            'id_rol_sistema' => 3, // Usuario
        ]);

        // Usuario moderador de prueba
        Usuario::create([
            'nombre_usuario' => 'moderador',
            'correo' => 'moderador@eventum.com',
            'contraseña' => Hash::make('password'),
            'id_rol_sistema' => 2, // Moderador
        ]);

        // Configuración del usuario admin
        ConfiguracionUsuario::create([
            'id_usuario' => 1,
            'tema' => 'futurista',
            'modo_oscuro' => 'dark',
            'idioma' => 'es',
            'zona_horaria' => 'America/Mexico_City',
            'animaciones_habilitadas' => true,
            'tamaño_fuente' => 16,
            'tipo_fuente' => 'Inter',
        ]);

        // Configuración del usuario regular
        ConfiguracionUsuario::create([
            'id_usuario' => 2,
            'tema' => 'futurista',
            'modo_oscuro' => 'dark',
            'idioma' => 'es',
            'zona_horaria' => 'America/Mexico_City',
            'animaciones_habilitadas' => true,
            'tamaño_fuente' => 16,
            'tipo_fuente' => 'Inter',
        ]);

        // Configuración del usuario moderador
        ConfiguracionUsuario::create([
            'id_usuario' => 3,
            'tema' => 'futurista',
            'modo_oscuro' => 'dark',
            'idioma' => 'es',
            'zona_horaria' => 'America/Mexico_City',
            'animaciones_habilitadas' => true,
            'tamaño_fuente' => 16,
            'tipo_fuente' => 'Inter',
        ]);

        // Evento de ejemplo
        Evento::create([
            'id_anfitrion' => 1,
            'titulo' => 'Fiesta de Bienvenida Eventum',
            'descripcion' => '¡Bienvenido a Eventum! Únete a nuestra fiesta de presentación.',
            'lugar' => 'Sala de Conferencias Principal',
            'sitio' => 'https://meet.google.com/eventum-demo',
            'id_tipo_presupuesto' => 2, // sugerido
            'presupuesto' => 500.00,
            'fecha_inicio' => now()->addDays(7),
            'hora_inicio' => '18:00',
            'fecha_fin' => now()->addDays(7),
            'hora_fin' => '22:00',
            'fecha_limite_invitacion' => now()->addDays(5),
            'codigo_evento' => strtoupper(substr(md5(uniqid()), 0, 8)),
        ]);
    }
}
