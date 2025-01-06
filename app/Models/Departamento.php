<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    // Tabla asociada al modelo
    protected $table = "departamentos";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_departamento';  // Campo que actúa como clave primaria

    // Campos asignables masivamente
    protected $fillable = ['departamento_nombre', 'departamento_descripcion'];  // Campos que se pueden llenar en masa

    // Relación: Un Departemanto tiene varios Expedientes
    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }

    // Relación: Un Departemanto tiene varios Usuarios
    public function usuarios()
    {
        return $this->hasMany(Expediente::class);
    }
}
