<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $fillable = [
        'nombre_usuario',
        'correo',
        'contraseña',
        'id_rol_sistema'
    ];

    protected $hidden = [
        'contraseña',
        'remember_token',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rolSistema()
    {
        return $this->belongsTo(RolSistema::class, 'id_rol_sistema', 'id_rol_sistema');
    }

    public function eventosCreados()
    {
        return $this->hasMany(Evento::class, 'id_anfitrion', 'id_usuario');
    }

    public function eventosParticipando()
    {
        return $this->belongsToMany(Evento::class, 'usuarios_eventos', 'id_usuario', 'id_evento')
                    ->withPivot('id_rol_evento', 'estado_invitacion')
                    ->withTimestamps();
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_usuario', 'id_usuario');
    }

    public function participaciones()
    {
        return $this->hasMany(Participacion::class, 'id_usuario', 'id_usuario');
    }

    public function solicitudesEnviadas()
    {
        return $this->hasMany(SolicitudInvitacion::class, 'id_usuario', 'id_usuario');
    }

    public function reportesEnviados()
    {
        return $this->hasMany(ReporteEvento::class, 'id_usuario', 'id_usuario');
    }

    public function cosasPorLlevar()
    {
        return $this->hasMany(CosaPorLlevar::class, 'id_usuario', 'id_usuario');
    }

    public function configuracion()
    {
        return $this->hasOne(ConfiguracionUsuario::class, 'id_usuario', 'id_usuario');
    }
}
