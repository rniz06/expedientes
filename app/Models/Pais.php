<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    // Tabla asociada al modelo
    protected $table = "paises";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_pais';  // Campo que actúa como clave primaria

    // Campos asignables masivamente
    protected $fillable = ['pais_nombre', 'pais_siglas'];  // Campos que se pueden llenar en masa
}
