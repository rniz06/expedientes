<?php

namespace App\Livewire;

use App\Models\Expediente;
use App\Models\Vistas\ExpedienteVt;
use Livewire\Component;

class Expedientes extends Component
{
    public $documento;
    public $prefijo = '';
    public $expediente;
    public $resultado; // Almacena los datos del expediente encontrado

    public function consultar()
    {
        $this->validate([
            'documento' => 'required',
            'prefijo' => 'required',
            'expediente' => 'required',
        ]);
        //$this->prefijo = "CBVP-2023";
        $query = $this->prefijo . '-' . $this->expediente;
        //$query = "CBVP-2024-00001";
        $this->resultado = ExpedienteVt::where('mesa_entrada_completa', $query)->first();

        if (!$this->resultado) {
            session()->flash('message', 'Expediente no encontrado.');
        }
    }
    public function render()
    {
        $prefijoAnhoExp = Expediente::distinct()->orderBy('mesa_entrada_prefix_anho', 'desc')->pluck('mesa_entrada_prefix_anho', 'mesa_entrada_prefix_anho')->toArray();
        return view('livewire.expedientes', compact('prefijoAnhoExp'));
    }
}
