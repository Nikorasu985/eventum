<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoSolicitud;

class EstadoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre_estado' => 'pendiente'],
            ['nombre_estado' => 'aceptada'],
            ['nombre_estado' => 'rechazada']
        ];

        foreach ($estados as $estado) {
            EstadoSolicitud::create($estado);
        }
    }
}