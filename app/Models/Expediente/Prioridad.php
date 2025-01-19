<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Expediente;
use Illuminate\Database\Eloquent\Model;

class Prioridad extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    // Tabla asociada al modelo
    protected $table = "expedientes_prioridades";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_expediente_prioridad';  // Campo que actúa como clave primaria

    // Campos asignables masivamente
    protected $fillable = ['expediente_prioridad'];  // Campos que se pueden llenar en masa

    // Relación: Un registro de Prioridad Puede estar presente en varios Expedientes
    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }
}
