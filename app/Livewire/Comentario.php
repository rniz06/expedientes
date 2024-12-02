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
    public $expandedIds;

    public function mount()
    {
        $this->expandedIds = collect();
    }

    public function toggleExpand($id)
    {
        $comentarioValido = ExpedienteComentario::where('id_expediente_comentario', $id)
            ->where('comentario_expediente_id', $this->record->id_expediente)
            ->exists();

        if (!$comentarioValido) {
            return;
        }

        $this->expandedIds->contains($id) 
            ? $this->expandedIds->forget($this->expandedIds->search($id))
            : $this->expandedIds->push($id);
    }

    public function render()
    {
        $comentarios = ExpedienteComentario::query()
            ->with('creadorComentario:id,name')
            ->where('comentario_expediente_id', $this->record->id_expediente)
            ->latest()
            ->paginate(3);

        return view('livewire.comentario', compact('comentarios'));
    }
}
