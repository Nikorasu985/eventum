<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoNotificacion;

class TipoNotificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre_tipo' => 'invitacion'],
            ['nombre_tipo' => 'solicitud'],
            ['nombre_tipo' => 'evento'],
            ['nombre_tipo' => 'recordatorio'],
            ['nombre_tipo' => 'aviso']
        ];

        foreach ($tipos as $tipo) {
            TipoNotificacion::create($tipo);
        }
    }
}
