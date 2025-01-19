<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    // Tabla asociada al modelo
    protected $table = "ciudades";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_ciudad';  // Campo que actúa como clave primaria

    // Campos asignables masivamente
    protected $fillable = ['ciudad_nombre'];  // Campos que se pueden llenar en masa

    /**
     * Relación de "Ciudad" a "Barrio" (uno a muchos).
     * Una ciudad puede tener muchos barrios.
     */
    public function barrios()
    {
        return $this->hasMany(Barrio::class);  // Relación "uno a muchos" con la tabla de barrios
    }

    // Relación: Una Ciudad tiene muchos Ciudadanos
    public function ciudadanos()
    {
        return $this->hasMany(Ciudadano::class);
    }
}
