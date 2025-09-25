<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoParticipacion;

class EstadoParticipacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre_estado' => 'confirmada'],
            ['nombre_estado' => 'no asistió'],
            ['nombre_estado' => 'cancelada']
        ];

        foreach ($estados as $estado) {
            EstadoParticipacion::create($estado);
        }
    }
}