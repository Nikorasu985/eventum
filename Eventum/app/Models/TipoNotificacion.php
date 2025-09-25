<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoNotificacion extends Model
{
    use HasFactory;

    protected $table = 'tipos_notificacion';
    protected $primaryKey = 'id_tipo_notificacion';
    
    protected $fillable = [
        'nombre_tipo'
    ];

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'id_tipo_notificacion', 'id_tipo_notificacion');
    }
}
