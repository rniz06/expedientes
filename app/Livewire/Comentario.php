<?php

namespace App\Livewire;

use App\Models\Expediente;
use App\Models\Expediente\Comentario as ExpedienteComentario;
use Livewire\Component;
use Livewire\WithPagination;

class Comentario extends Component
{
    use WithPagination;

    public Expediente $record;

    public function render()
    {
        $comentarios = ExpedienteComentario::select('id_expediente_comentario', 'comentario_expediente_id', 'expediente_comentario', 'creador_usuario_id', 'created_at')
            ->with('creadorComentario:id,name')->where('comentario_expediente_id', $this->record->id)->orderBy('created_at', 'desc')->paginate(3);
        return view('livewire.comentario', ['comentarios' => $comentarios]);
    }
}
