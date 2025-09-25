<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteEvento extends Model
{
    use HasFactory;

    protected $table = 'reportes_evento';
    protected $primaryKey = 'id_reporte';
    
    protected $fillable = [
        'id_evento',
        'id_usuario',
        'motivo',
        'fecha_reporte',
        'estado'
    ];

    protected $casts = [
        'fecha_reporte' => 'datetime'
    ];

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento', 'id_evento');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
