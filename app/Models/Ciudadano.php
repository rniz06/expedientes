<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudadano extends Model
{
    // Tabla asociada al modelo
    protected $table = "ciudadanos";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_ciudadano';  // Campo que actúa como clave primaria

    // Campos asignables masivamente
    protected $fillable = [ // Campos que se pueden llenar en masa
        'nombres',
        'apellidos',
        'nombre_completo',
        'ci',
        'ruc',
        'telefono',
        'email',
        'direccion_particular',
        'tipo_persona',
        'barrio_id',
        'ciudad_id',
        'creado_por',
        'actualizado_por',
    ];

    // Relación: Un Ciudadano pertenece a un Barrio
    public function barrio()
    {
        return $this->belongsTo(Barrio::class, 'barrio_id');
    }

    // Relación: Un Ciudadano pertenece a una Ciudad
    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    // Relación: Un Ciudadano tiene varios Expedientes
    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }

    // Relación: Un Registro de ciudadano puede ser agregado por un solo usuario
    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    // Relación: Un Registro de ciudadano puede ser agregado por un solo usuario
    public function actualizadoPor()
    {
        return $this->belongsTo(User::class, 'actualizado_por');
    }

}
