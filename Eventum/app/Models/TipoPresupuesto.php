<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPresupuesto extends Model
{
    use HasFactory;

    protected $table = 'tipos_presupuesto';
    protected $primaryKey = 'id_tipo_presupuesto';
    
    protected $fillable = [
        'nombre_tipo'
    ];

    public function eventos()
    {
        return $this->hasMany(Evento::class, 'id_tipo_presupuesto', 'id_tipo_presupuesto');
    }
}
