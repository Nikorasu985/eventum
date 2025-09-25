<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RolEvento;

class RolEventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nombre_rol' => 'Anfitrión',
                'descripcion' => 'Creador y organizador del evento'
            ],
            [
                'nombre_rol' => 'Invitado',
                'descripcion' => 'Usuario invitado al evento'
            ],
            [
                'nombre_rol' => 'Participante',
                'descripcion' => 'Usuario que participa en el evento'
            ]
        ];

        foreach ($roles as $rol) {
            RolEvento::create($rol);
        }
    }
}