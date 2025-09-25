<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    
    protected $fillable = [
        'id_usuario',
        'id_evento',
        'id_tipo_notificacion',
        'contenido',
        'leida',
        'fecha_envio'
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
        'leida' => 'boolean'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    public function tipoNotificacion()
    {
        return $this->belongsTo(TipoNotificacion::class, 'id_tipo_notificacion', 'id_tipo_notificacion');
    }
}
