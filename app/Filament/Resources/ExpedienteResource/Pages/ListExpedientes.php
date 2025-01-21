<?php

namespace App\Filament\Resources\ExpedienteResource\Pages;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ExpedienteResource;
use App\Models\Expediente\Estado as ExpedienteEstado;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExpedientes extends ListRecords
{
    protected static string $resource = ExpedienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Añadir Expediente')->icon('heroicon-o-folder-plus'),
        ];
    }

    public function getTabs(): array
    {
        $estadoFinalizadoId = ExpedienteEstado::where('expediente_estado', 'FINALIZADO')->first();
        $estadoDerivado = ExpedienteEstado::where('expediente_estado', 'DERIVADO')->first();
        $estadoEnProgreso = ExpedienteEstado::where('expediente_estado', 'EN PROGRESO')->first();
        return [
            'en_progreso' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('expediente_estado_id', $estadoEnProgreso->id_expediente_estado)),
            'derivado' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('expediente_estado_id', $estadoDerivado->id_expediente_estado)),
            // 'con_copia' => Tab::make()
            //     ->modifyQueryUsing(fn(Builder $query) => $query->where('expediente_estado_id', $estadoDerivado->id_expediente_estado)),
            'finalizados' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('expediente_estado_id', $estadoFinalizadoId->id_expediente_estado)),
            'todos' => Tab::make(),
        ];
    }
}
