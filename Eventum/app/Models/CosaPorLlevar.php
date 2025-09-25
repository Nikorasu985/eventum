<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CosaPorLlevar extends Model
{
    use HasFactory;

    protected $table = 'cosas_por_llevar';
    protected $primaryKey = 'id_cosa';
    
    protected $fillable = [
        'id_evento',
        'id_usuario',
        'nombre',
        'cantidad',
        'observaciones',
        'estado'
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
