<?php

namespace App\Models\Vistas;

use App\Models\Expediente;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $connection = "db_personal";

    protected $table = "vt_personales";

    protected $primaryKey = 'idpersonal';

    // Relacion Inversa del personal titular de un expediente
    public function expedienteTitular()
    {
        return $this->hasMany(Expediente::class, 'personal_id', 'idpersonal');
    }

    public static function obtenerNombreCodigoCategoria()
    {
        return Personal::selectRaw('idpersonal AS id, CONCAT(nombrecompleto, \' - \', codigo, \' - \', categoria) AS label')
            ->orderBy('nombrecompleto')
            ->get()
            ->pluck('label', 'id');
    }
}
