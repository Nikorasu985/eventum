<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoSolicitud extends Model
{
    use HasFactory;

    protected $table = 'estados_solicitud';
    protected $primaryKey = 'id_estado_solicitud';
    
    protected $fillable = [
        'nombre_estado'
    ];

    public function solicitudesInvitacion()
    {
        return $this->hasMany(SolicitudInvitacion::class, 'id_estado_solicitud', 'id_estado_solicitud');
    }
}
