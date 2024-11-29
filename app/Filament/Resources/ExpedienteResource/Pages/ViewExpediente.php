<?php

namespace App\Filament\Resources\ExpedienteResource\Pages;

use Filament\Infolists\Components\Actions\Action as aAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use App\Filament\Resources\ExpedienteResource;
use App\Livewire\Comentario;
use App\Models\Expediente;
use App\Models\Expediente\Comentario as ExpedienteComentario;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Section;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViewExpediente extends ViewRecord
{
    protected static string $resource = ExpedienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Logica que crea un boton para abri un modal y realizar un comentario
            Action::make('comentar')
                ->color('gray')
                ->form([
                    Textarea::make('comentario')
                        ->label('')
                        ->required()
                ])
                ->action(function (array $data, Expediente $record) {
                    $comentario = new ExpedienteComentario();

                    $comentario->expediente_comentario = $data['comentario'];
                    $comentario->comentario_expediente_id = $record->id;
                    $comentario->creador_usuario_id = Auth::id();
                    $comentario->save();
                }),

        ];
    }

    public function  infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Grid::make(3)
                    ->schema([
                        Livewire::make(Comentario::class)->columnSpan(2),
                        Section::make('Detalles del Expediente')
                            ->schema([
                                TextEntry::make('expediente_asunto')->label('Asunto:'),
                                TextEntry::make('mesa_entrada_completa')->label('N° Mesa Entrada:')->badge(),
                                TextEntry::make('ciudadano.nombre_completo')->label('Responsable:'),
                                TextEntry::make('departamento.departamento_nombre')->label('Dirección Actual:')->badge(),
                                RepeatableEntry::make('archivos')
                                    ->schema([
                                        TextEntry::make('archivo_nombre_original')->label('')->badge()->openUrlInNewTab()
                                        // ->url(fn($record) => route('expediente.descargar.archivo', $record->id))
                                    ])
                            ])->columnSpan(1)
                    ])
            ]);
    }
}
