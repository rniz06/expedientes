<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Expediente;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;
    // Tabla asociada al modelo
    protected $table = "expedientes_comentarios";  // Nombre de la tabla en la base de datos

    // Clave primaria de la tabla
    protected $primaryKey = 'id_expediente_comentario';  // Campo que actúa como clave primaria

    // Campos asignables masivamente 
    protected $fillable = [
        'expediente_comentario',
        'comentario_expediente_id',
        'creador_usuario_id',
        'actualizacion_usuario_id',
    ];  // Campos que se pueden llenar en masa

    /**
     * Relación de "Comentario" a "Expediente" (uno a muchos inverso).
     * Cada comentario pertenece a un Expediente.
     */
    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'comentario_expediente_id', 'id_expediente');
    }

    // Relación: Un Comentario tiene un solo Usuario creador
    public function creadorComentario()
    {
        return $this->belongsTo(User::class, 'creador_usuario_id');
    }

    // Relación: Un Comentario tiene un solo Usuario Actualizador
    public function actualizacionComentario()
    {
        return $this->belongsTo(User::class, 'actualizacion_usuario_id');
    }

}
