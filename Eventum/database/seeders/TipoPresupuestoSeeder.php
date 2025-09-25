<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoPresupuesto;

class TipoPresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre_tipo' => 'fijo'],
            ['nombre_tipo' => 'sugerido']
        ];

        foreach ($tipos as $tipo) {
            TipoPresupuesto::create($tipo);
        }
    }
}