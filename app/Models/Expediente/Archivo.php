<?php

namespace App\Models\Expediente;

use App\Models\Expediente;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    // Tabla asociada al modelo
    protected $table = "expedientes_archivos";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_expediente_archivo';  // Campo que actúa como clave primaria

    // Campos asignables masivamente 
    protected $fillable = [
        'archivo_nombre_original',
        'archivo_nombre_generado',
        'archivo_ruta',
        'archivo_tamano',
        'archivo_tipo',
        'archivo_descripcion',
        'archivo_fecha_subida',
        'archivo_usuario_id',
        'archivo_expediente_id',
    ];  // Campos que se pueden llenar en masa

    /**
     * Relación de "Archivo" a "User" (uno a muchos inverso).
     * Cada archivo pertenece a una usuario que lo agrego.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'archivo_usuario_id');
    }

    /**
     * Relación de "Archivo" a "Expediente" (uno a muchos inverso).
     * Cada archivo pertenece a un Expediente.
     */
    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'archivo_expediente_id', 'id_expediente');
    }

}
