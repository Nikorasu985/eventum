<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participacion extends Model
{
    use HasFactory;

    protected $table = 'participaciones';
    protected $primaryKey = 'id_participacion';
    
    protected $fillable = [
        'id_evento',
        'id_usuario',
        'id_estado_participacion',
        'fecha_confirmacion'
    ];

    protected $casts = [
        'fecha_confirmacion' => 'datetime'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function estadoParticipacion()
    {
        return $this->belongsTo(EstadoParticipacion::class, 'id_estado_participacion', 'id_estado_participacion');
    }
}
