<?php

namespace App\Models;

use App\Models\Expediente\Archivo;
use App\Models\Expediente\Comentario;
use App\Models\Expediente\Estado as ExpedienteEstado;
use App\Models\Expediente\Prioridad;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    // Tabla asociada al modelo
    protected $table = "expedientes";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_expediente';  // Campo que actúa como clave primaria

    // Campos asignables masivamente
    protected $fillable = [
        'expediente_asunto',
        'mesa_entrada_completa',
        'mesa_entrada_prefix_anho',
        'nro_mesa_entrada',        
        'nro_mesa_entrada_anho',
        'mesa_entrada_anho',
        'expediente_estado_id',
        'expediente_prioridad_id',
        'expediente_departamento_id',
        'expediente_ciudadano_id',
        'agrego_usuario_id',
    ];

    // Relación: Un Expediente tiene un solo Estado
    public function estado()
    {
        return $this->belongsTo(ExpedienteEstado::class, 'expediente_estado_id');
    }

    // Relación: Un Expediente tiene un solo Departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'expediente_departamento_id');
    }

    // Relación: Un Expediente tiene una sola Prioridad
    public function prioridad()
    {
        return $this->belongsTo(Prioridad::class, 'expediente_prioridad_id');
    }

    // Relación: Un Expediente tiene un solo Ciudadano
    public function ciudadano()
    {
        return $this->belongsTo(Ciudadano::class, 'expediente_ciudadano_id');
    }

    // Relación: Un Expediente tiene un solo Usuario agregado
    public function agregadoPor()
    {
        return $this->belongsTo(User::class, 'agrego_usuario_id');
    }

    /**
     * Relación de "Expediente" a "Comentario" (uno a muchos).
     * Un Expediente puede tener muchos Comentarios.
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'comentario_expediente_id', 'id_expediente');
    }

    /**
     * Relación de "Expediente" a "Archivo" (uno a muchos).
     * Un Expediente puede tener agregar muchos archivos.
     */
    public function archivos()
    {
        return $this->hasMany(Archivo::class, 'archivo_expediente_id', 'id_expediente');  // Relación "uno a muchos" con la tabla de barrios
    }
}
