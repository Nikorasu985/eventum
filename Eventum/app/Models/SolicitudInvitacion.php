<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudInvitacion extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_invitacion';
    protected $primaryKey = 'id_solicitud';
    
    protected $fillable = [
        'id_evento',
        'id_usuario',
        'id_tipo_solicitud',
        'id_estado_solicitud',
        'mensaje',
        'fecha_envio'
    ];

    protected $casts = [
        'fecha_envio' => 'datetime'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function tipoSolicitud()
    {
        return $this->belongsTo(TipoSolicitud::class, 'id_tipo_solicitud', 'id_tipo_solicitud');
    }

    public function estadoSolicitud()
    {
        return $this->belongsTo(EstadoSolicitud::class, 'id_estado_solicitud', 'id_estado_solicitud');
    }
}
