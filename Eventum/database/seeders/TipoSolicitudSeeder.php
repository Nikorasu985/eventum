<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoSolicitud;

class TipoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre_tipo' => 'codigo'],
            ['nombre_tipo' => 'directa']
        ];

        foreach ($tipos as $tipo) {
            TipoSolicitud::create($tipo);
        }
    }
}