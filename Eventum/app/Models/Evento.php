<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'eventos';
    protected $primaryKey = 'id_evento';
    protected $fillable = [
        'id_anfitrion',
        'titulo',
        'descripcion',
        'lugar',
        'sitio',
        'id_tipo_presupuesto',
        'presupuesto',
        'numero_integrantes',
        'codigo_evento',
        'fecha_inicio',
        'hora_inicio',
        'fecha_fin',
        'hora_fin',
        'fecha_limite_invitacion'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_limite_invitacion' => 'date',
        'presupuesto' => 'decimal:2',
        'numero_integrantes' => 'integer'
    ];

    public function anfitrion()
    {
        return $this->belongsTo(Usuario::class, 'id_anfitrion', 'id_usuario');
    }

    public function tipoPresupuesto()
    {
        return $this->belongsTo(TipoPresupuesto::class, 'id_tipo_presupuesto', 'id_tipo_presupuesto');
    }

    public function participantes()
    {
        return $this->belongsToMany(Usuario::class, 'usuarios_eventos', 'id_evento', 'id_usuario')
                    ->withPivot('id_rol_evento', 'estado_invitacion')
                    ->withTimestamps();
    }


    public function solicitudes()
    {
        return $this->hasMany(SolicitudInvitacion::class, 'id_evento', 'id_evento');
    }

    public function participaciones()
    {
        return $this->hasMany(Participacion::class, 'id_evento', 'id_evento');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_evento', 'id_evento');
    }

    public function reportes()
    {
        return $this->hasMany(ReporteEvento::class, 'id_evento', 'id_evento');
    }

    public function cosasPorLlevar()
    {
        return $this->hasMany(CosaPorLlevar::class, 'id_evento', 'id_evento');
    }

    public function generarCodigoEvento()
    {
        $this->codigo_evento = strtoupper(substr(md5(uniqid()), 0, 8));
        return $this->codigo_evento;
    }
}
