<?php

namespace App\Models\Vistas;

use Illuminate\Database\Eloquent\Model;

class ExpedienteVt extends Model
{
    protected $table = 'vt_expedientes';

    protected $primaryKey = 'id_expediente';

    public $timestamps = false;
}
