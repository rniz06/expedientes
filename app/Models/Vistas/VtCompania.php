<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;

class VtCompania extends Model
{
    protected $connection = "db_companias";

    protected $table = "vt_companias";

    protected $primaryKey = 'idcompanias';

    public static function obtenerCompaniaDepartamentoCiudad()
    {
        return VtCompania::selectRaw('idcompanias AS id, CONCAT(compania, \' - \', departamento, \' - \', ciudad) AS label')
            ->orderBy('compania')
            ->orderBy('departamento')
            ->orderBy('ciudad')
            ->get()
            ->pluck('label', 'id');
    }
}
