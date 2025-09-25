<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolEvento extends Model
{
    use HasFactory;

    protected $table = 'roles_evento';
    protected $primaryKey = 'id_rol_evento';
    
    protected $fillable = [
        'nombre_rol',
        'descripcion'
    ];

    public function usuariosEventos()
    {
        return $this->hasMany(UsuarioEvento::class, 'id_rol_evento', 'id_rol_evento');
    }
}
