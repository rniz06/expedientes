<?php

namespace App\Filament\Resources\ExpedienteResource\Pages;

use Filament\Forms\Components\Select;
use Illuminate\Support\Str;
use Filament\Infolists\Components\Actions\Action as aAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use App\Filament\Resources\ExpedienteResource;
use App\Livewire\Comentario;
use App\Models\Departamento;
use App\Models\Expediente;
use App\Models\Expediente\Archivo as ExpedienteArchivo;
use App\Models\Expediente\Comentario as ExpedienteComentario;
use App\Models\Expediente\Estado as ExpedienteEstado;
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
                    $comentario->comentario_expediente_id = $record->id_expediente;
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
                        ->directory(fn(Expediente $record) => 'expedientes/' . $record->created_at->format('Y/m') . '/' . Str::slug($record->expediente_asunto))
                        ->preserveFilenames()
                        ->required(),
                    Textarea::make('descripcion')->label('Descripción')
                ])
                ->action(function (array $data, Expediente $record) {
                    // Obtener información del archivo
                    $filename = basename($data['archivo']);
                    $fileSize = Storage::disk('public')->size($data['archivo']);
                    $fileMimeType = Storage::disk('public')->mimeType($data['archivo']);

                    // Crear archivo con método create
                    ExpedienteArchivo::create([
                        'archivo_nombre_original' => $filename,
                        'archivo_nombre_generado' => $filename,
                        'archivo_ruta' => $data['archivo'],
                        'archivo_tamano' => $fileSize,
                        'archivo_tipo' => $fileMimeType,
                        'archivo_descripcion' => $data['descripcion'] ?? null,
                        'archivo_fecha_subida' => now(),
                        'archivo_usuario_id' => Auth::id(),
                        'archivo_expediente_id' => $record->id_expediente
                    ]);
                }),

            // Logica que crea un boton para abri un modal y Derivar un expediente
            Action::make('derivar')
                ->color('gray')
                ->fillForm(fn(Expediente $record): array => [
                    'expediente_departamento_id' => $record->expediente_departamento_id,
                ])
                ->form([
                    Select::make('expediente_departamento_id')
                        ->label('Seleccionar Departamento:')
                        ->options(Departamento::pluck('departamento_nombre', 'id_departamento'))
                        ->searchable()
                        ->preload()
                        ->required(),
                ])
                ->action(function (array $data, Expediente $record) {
                    // Obtener el usuario autenticado, el departamento antiguo y el nuevo departameto
                    $usuario = Auth::user();
                    $departamentoViejo = $record->departamento->departamento_nombre;
                    $departamentoNuevo = Departamento::findOrFail($data['expediente_departamento_id'])->departamento_nombre;

                    // Actualizar el expediente de manera más concisa
                    $record->update([
                        'expediente_departamento_id' => $data['expediente_departamento_id']
                    ]);

                    // Crear el comentario en una sola línea
                    ExpedienteComentario::create([
                        'expediente_comentario' => "{$usuario->name} derivó el expediente de {$departamentoViejo} a {$departamentoNuevo}",
                        'comentario_expediente_id' => $record->id_expediente,
                        'creador_usuario_id' => $usuario->id,
                    ]);
                }),

            // Logica que crea un boton para abri un modal y dar por finalizado el tramite del expediente
            Action::make('finalizar')
                ->color('gray')
                ->requiresConfirmation()
                ->action(function (array $data, Expediente $record) {
                    $usuario = Auth::user();
                    $estadoFinalizado = ExpedienteEstado::where('expediente_estado', 'FINALIZADO')->firstOrFail();

                    $record->update([
                        'expediente_estado_id' => $estadoFinalizado->id_expediente_estado
                    ]);

                    ExpedienteComentario::create([
                        'expediente_comentario' => "{$usuario->name} dio por finalizado el tramite de este expediente.",
                        'comentario_expediente_id' => $record->id_expediente,
                        'creador_usuario_id' => Auth::id()
                    ]);
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
                                TextEntry::make('estado.expediente_estado')->label('N° Mesa Entrada:')->badge(),
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
