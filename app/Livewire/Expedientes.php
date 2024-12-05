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
        // Se concatena el prefijo con el nro  de expediente para arma el campo mesa_entrada_completa
        $query = sprintf('%s-%s', $this->prefijo, $this->expediente);

        $this->resultado = ExpedienteVt::where([
            'mesa_entrada_completa' => $query,
            'ciudadano_ci' => $this->documento
        ])->first();

        if (!$this->resultado) {
            session()->flash('message', 'Expediente no encontrado.');
        }
    }
    public function render()
    {
        $prefijoAnhoExp = Expediente::orderByDesc('mesa_entrada_prefix_anho')
            ->pluck('mesa_entrada_prefix_anho')
            ->unique()
            ->toArray();

        return view('livewire.expedientes', compact('prefijoAnhoExp'));
    }
}
