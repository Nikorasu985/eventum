<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionUsuario extends Model
{
    use HasFactory;

    protected $table = 'configuraciones_usuario';
    protected $primaryKey = 'id_configuracion';
    protected $fillable = [
        'id_usuario',
        'tema',
        'modo_oscuro',
        'colores_personalizados',
        'configuracion_dashboard',
        'notificaciones_config',
        'idioma',
        'zona_horaria',
        'animaciones_habilitadas',
        'tamaño_fuente',
        'tipo_fuente',
        'widgets_dashboard'
    ];

    protected $casts = [
        'colores_personalizados' => 'array',
        'configuracion_dashboard' => 'array',
        'notificaciones_config' => 'array',
        'widgets_dashboard' => 'array',
        'animaciones_habilitadas' => 'boolean'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
