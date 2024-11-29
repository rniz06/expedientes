<?php

namespace App\Filament\Resources\ExpedienteResource\Pages;

use Illuminate\Support\Str;
use Filament\Infolists\Components\Actions\Action as aAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use App\Filament\Resources\ExpedienteResource;
use App\Livewire\Comentario;
use App\Models\Expediente;
use App\Models\Expediente\Archivo as ExpedienteArchivo;
use App\Models\Expediente\Comentario as ExpedienteComentario;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Livewire;
use Filament\Infolists\Components\Section;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

            // Logica que crea un boton para abri un modal y subir un archivo
            Action::make('archivo')
                ->label('Subir Archivo')
                ->color('gray')
                ->form([
                    FileUpload::make('archivo')
                        ->label('')
                        ->directory(fn(Expediente $record) => 'expedientes/' . $record->created_at->format('Y') . '/' . $record->created_at->format('m') . '/' . Str::slug($record->expediente_asunto))
                        ->preserveFilenames()
                        ->required(),
                    Textarea::make('descripcion')->label('Descripción')

                ])
                ->action(function (array $data, Expediente $record) {

                    $archivo = new ExpedienteArchivo();
                    $archivo->archivo_nombre_original = basename($data['archivo']);
                    $archivo->archivo_nombre_generado = basename($data['archivo']);
                    $archivo->archivo_ruta = $data['archivo'];
                    $archivo->archivo_tamano = Storage::disk('public')->size($data['archivo']);
                    $archivo->archivo_tipo = Storage::disk('public')->mimeType($data['archivo']);
                    $archivo->archivo_descripcion = $data['descripcion'];
                    $archivo->archivo_fecha_subida = Carbon::now();
                    $archivo->archivo_usuario_id = Auth::id();
                    $archivo->archivo_expediente_id = $record->id_expediente;
                    $archivo->save();
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
                                            ->url(fn(ExpedienteArchivo $record) => route('expediente.descargar.archivo', $record->id_expediente_archivo))
                                    ])->contained(false)
                            ])->columnSpan(1)
                    ])
            ]);
    }
}
