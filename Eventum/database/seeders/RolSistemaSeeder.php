<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RolSistema;

class RolSistemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nombre_rol' => 'Administrador',
                'descripcion' => 'Rol con acceso completo al sistema'
            ],
            [
                'nombre_rol' => 'Moderador',
                'descripcion' => 'Rol con permisos de moderación'
            ],
            [
                'nombre_rol' => 'Usuario',
                'descripcion' => 'Rol básico de usuario'
            ]
        ];

        foreach ($roles as $rol) {
            RolSistema::create($rol);
        }
    }
}