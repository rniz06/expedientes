<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\Model;

class DepartamentoHistorial extends Model
{
    //
    protected $table = 'expedientes_departamentos_historial';
    
    protected $fillable = [
        'expediente_id',
        'departamento_origen_id',
        'departamento_destino_id',
        'usuario_id',
    ];
}
