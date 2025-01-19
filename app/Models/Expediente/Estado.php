<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Expediente;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    
    // Tabla asociada al modelo
    protected $table = "expedientes_estados";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_expediente_estado';  // Campo que actúa como clave primaria

    // Campos asignables masivamente
    protected $fillable = ['expediente_estado'];  // Campos que se pueden llenar en masa

    // Relación: Un Estado tiene varios Expedientes
    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }

}
