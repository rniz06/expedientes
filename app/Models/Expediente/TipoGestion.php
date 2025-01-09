<?php

namespace App\Models\Expediente;

use App\Models\Expediente;
use Illuminate\Database\Eloquent\Model;

class TipoGestion extends Model
{
    // Tabla asociada al modelo
    protected $table = "expedientes_tipo_gestiones";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_tipo_gestion';  // Campo que actúa como clave primaria

    // Campos asignables masivamente
    protected $fillable = [
        'tipo_gestion',
        'descripcion',
    ];

    /**
     * Relación de "TipoGestion" a "Expediente" (uno a muchos inverso).
     * Cada expediente tiene un solo tipo de gestion.
     */
    public function expedientes()
    {
        return $this->hasMany(Expediente::class);  // Relación "uno a muchos" con la tabla de barrios
    }
}
