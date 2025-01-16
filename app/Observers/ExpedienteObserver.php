<?php

namespace App\Observers;

use App\Models\Expediente;
use App\Models\Expediente\Comentario as ExpedienteComentario;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ExpedienteObserver
{
    /**
     * Handle the Expediente "created" event.
     */
    public function created(Expediente $expediente): void
    {
        // GENERAR UN COMENTARIO AUTOMATICO DE MESA ENTRADA AL CREAR EL EXPEDIENTE
        $usuario = User::findOrFail($expediente->agrego_usuario_id);
        $comentario = "{$usuario->name} dió mesa de entrada a al expediente.";
        ExpedienteComentario::create([
            'expediente_comentario' => $comentario,
            'comentario_expediente_id' => $expediente->id_expediente,
            'creador_usuario_id' => $usuario->id,
        ]);
    }

    /**
     * Handle the Expediente "updated" event.
     */
    public function updated(Expediente $expediente): void
    {
        //
    }

    /**
     * Handle the Expediente "deleted" event.
     */
    public function deleted(Expediente $expediente): void
    {
        //
    }

    /**
     * Handle the Expediente "restored" event.
     */
    public function restored(Expediente $expediente): void
    {
        //
    }

    /**
     * Handle the Expediente "force deleted" event.
     */
    public function forceDeleted(Expediente $expediente): void
    {
        //
    }
}
