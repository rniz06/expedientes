<?php

namespace App\Models\Expediente;

use App\Models\Expediente;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class TipoTitular extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = "expedientes_tipo_titulares";

    protected $primaryKey = 'id_tipo_titular';

    protected $fillable = [
        'tipo_titular',
    ];

    /**
     * Relación de "TipoTitular" a "Expediente" (uno a muchos inverso).
     * Cada expediente tiene un solo tipo de titular.
     */
    public function expedientes()
    {
        return $this->hasMany(Expediente::class);  // Relación "uno a muchos" con la tabla de barrios
    }
}
