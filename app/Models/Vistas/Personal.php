<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $connection = "db_personal";

    protected $table = "vt_personales";

    protected $primaryKey = 'idpersonal';

    public static function obtenerNombreCodigoCategoria()
    {
        return Personal::selectRaw('idpersonal AS id, CONCAT(nombrecompleto, \' - \', codigo, \' - \', categoria) AS label')
            ->orderBy('nombrecompleto')
            ->get()
            ->pluck('label', 'id');
    }
}
