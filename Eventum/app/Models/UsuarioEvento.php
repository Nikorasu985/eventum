<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioEvento extends Model
{
    use HasFactory;

    protected $table = 'usuarios_eventos';
    protected $primaryKey = 'id_usuario_evento';
    
    protected $fillable = [
        'id_usuario',
        'id_evento',
        'id_rol_evento',
        'estado_invitacion'
    ];

    protected $casts = [
        'estado_invitacion' => 'string'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    public function rolEvento()
    {
        return $this->belongsTo(RolEvento::class, 'id_rol_evento', 'id_rol_evento');
    }
}
