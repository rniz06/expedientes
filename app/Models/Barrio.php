<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Barrio extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    
    // Tabla asociada al modelo
    protected $table = "ciudades_barrios";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_barrio';  // Campo que actúa como clave primaria

    // Campos asignables masivamente
    protected $fillable = ['barrio_nombre', 'barrio_ciudad_id'];  // Campos que se pueden llenar en masa

    /**
     * Relación de "Barrio" a "Ciudad" (uno a muchos inverso).
     * Cada barrio pertenece a una ciudad.
     */
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'barrio_ciudad_id');
    }
    
    // Relación: Un Barrio tiene muchos Ciudadanos
    public function ciudadanos()
    {
        return $this->hasMany(Ciudadano::class);
    }
}
