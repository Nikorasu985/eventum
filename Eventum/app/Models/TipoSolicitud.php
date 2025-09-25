<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoSolicitud extends Model
{
    use HasFactory;

    protected $table = 'tipos_solicitud';
    protected $primaryKey = 'id_tipo_solicitud';
    
    protected $fillable = [
        'nombre_tipo'
    ];

    public function solicitudesInvitacion()
    {
        return $this->hasMany(SolicitudInvitacion::class, 'id_tipo_solicitud', 'id_tipo_solicitud');
    }
}
