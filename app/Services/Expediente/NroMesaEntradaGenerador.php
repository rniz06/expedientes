<?php

namespace App\Services\Expediente;

use App\Models\Expediente;

class NroMesaEntradaGenerador
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Metodo para generar automaticamente un numero de mesa de entrada a retornar en el recurso.
     */
    public static function nroMesaEntradaGenerador()
    {
        $anho = date('Y'); // Año completo, por ejemplo, "2024"
        $prefijo = "CBVP";

        // Obtener el último expediente que coincida con el año actual
        $ultimoExpediente = Expediente::where('mesa_entrada_completa', 'like', "{$prefijo}-{$anho}-%")
            ->orderBy('id_expediente', 'desc') // Asegurarse de obtener el último registro
            ->first();

        if ($ultimoExpediente) {
            // Extraer el número después del año
            $partes = explode('-', $ultimoExpediente->mesa_entrada_completa);
            $numeroActual = end($partes); // Tomar la última parte (el número)
            $nuevoNumero = str_pad((int)$numeroActual + 1, 5, '0', STR_PAD_LEFT); // Incrementar y rellenar con ceros
        } else {
            // Si no hay registros para el año actual, empezar desde el 1
            $nuevoNumero = "00001";
        }

        // Devolver el nuevo número en el formato requerido
        return "{$prefijo}-{$anho}-{$nuevoNumero}";
    }
}
