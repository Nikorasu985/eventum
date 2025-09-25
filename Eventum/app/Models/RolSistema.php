<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolSistema extends Model
{
    use HasFactory;

    protected $table = 'roles_sistema';
    protected $primaryKey = 'id_rol_sistema';
    
    protected $fillable = [
        'nombre_rol',
        'descripcion'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_rol_sistema', 'id_rol_sistema');
    }
}
