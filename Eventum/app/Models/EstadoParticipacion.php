<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoParticipacion extends Model
{
    use HasFactory;

    protected $table = 'estados_participacion';
    protected $primaryKey = 'id_estado_participacion';
    
    protected $fillable = [
        'nombre_estado'
    ];

    public function participaciones()
    {
        return $this->hasMany(Participacion::class, 'id_estado_participacion', 'id_estado_participacion');
    }
}
