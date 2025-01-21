<?php

namespace App\Models\Expediente;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class DepartamentoConcopia extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'expedientes_departamentos_concopia';
    
    protected $fillable = [
        'expediente_id',
        'departamento_id',
    ];
}
