<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class DepartamentoHistorial extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    
    //
    protected $table = 'expedientes_departamentos_historial';
    
    protected $fillable = [
        'expediente_id',
        'departamento_origen_id',
        'departamento_destino_id',
        'usuario_id',
    ];
}
