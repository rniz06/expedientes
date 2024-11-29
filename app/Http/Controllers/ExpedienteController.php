<?php

namespace App\Http\Controllers;

use App\Models\Expediente\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpedienteController extends Controller
{
    //
    /*******************************************************************************
    * Descarga un archivo del expediente correspondiente al registro especificado  *
    *******************************************************************************/
    public function descargarArchivo($record)
    {
        $archivo = Archivo::findOrFail($record);

        $contenido = Storage::disk('public')->path($archivo->archivo_ruta);

        return response()->download($contenido, $archivo->archivo_nombre_original);
    }
}
