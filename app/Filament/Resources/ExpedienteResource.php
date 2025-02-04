<?php

namespace App\Filament\Resources;

use Filament\Notifications\Notification;
use App\Filament\Resources\ExpedienteResource\Pages;
use App\Filament\Resources\ExpedienteResource\RelationManagers;
use App\Models\Departamento;
use App\Models\Expediente;
use App\Models\Expediente\Comentario as ExpedienteComentario;
use App\Models\Expediente\DepartamentoHistorial;
use App\Models\Expediente\Estado as ExpedienteEstado;
use App\Models\Expediente\Prioridad as ExpedientePrioridad;
use App\Models\Expediente\TipoFuente;
use App\Models\Expediente\TipoGestion;
use App\Models\Vistas\Personal as VistaPersonal;
use App\Models\Vistas\VtCompania;
use App\Services\Expediente\NroMesaEntradaGenerador;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Relationship;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpedienteResource extends Resource
{
    protected static ?string $model = Expediente::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('tipo_fuente_id')
                            ->label('Tipo de fuente:')
                            ->relationship('tipoFuente', 'tipo_fuente')
                            ->live()
                            ->required(),
                        Forms\Components\Select::make('tipo_titular_id')
                            ->label('Tipo de Titular:')
                            ->relationship('tipoTitular', 'tipo_titular')
                            ->live()
                            ->required(),
                    ])->columns(2),
                Forms\Components\Section::make()
                    ->schema([

                        Forms\Components\TextInput::make('expediente_asunto')
                            ->label('Asunto:')
                            ->required()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('mesa_entrada_completa')
                            ->label('N° Mesa de Entrada:')
                            //->default(fn() => static::nroMesaEntradaGenerador())
                            ->default(NroMesaEntradaGenerador::nroMesaEntradaGenerador())
                            ->required()
                            ->maxLength(20),
                        Forms\Components\Select::make('personal_id')
                            ->label('Titular:')
                            ->visible(function (Forms\Get $get) {
                                return $get('tipo_titular_id') == 2; // Visible cuando tipo_titular_id es igual a 2 BOMBEROS
                            })
                            ->required()
                            ->options(VistaPersonal::obtenerNombreCodigoCategoria())
                            ->searchable()
                            ->preload()
                            ->searchDebounce(1000)
                            ->optionsLimit(20),
                        Forms\Components\Select::make('tit_departameto_id')
                            ->label('Titular:')
                            ->relationship('departamentoTitular', 'departamento_nombre')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->visible(function (Forms\Get $get) {
                                return $get('tipo_titular_id') == 4; // Visible cuando tipo_titular_id es igual a 4 DEPARTAMENTOS
                            }),
                        Forms\Components\Select::make('tit_compania_id')
                            ->label('Titular:')
                            ->visible(function (Forms\Get $get) {
                                return $get('tipo_titular_id') == 3; // Visible cuando tipo_titular_id es igual a 2 BOMBEROS
                            })
                            ->required()
                            ->options(VtCompania::obtenerCompaniaDepartamentoCiudad())
                            ->searchable()
                            ->preload()
                            ->searchDebounce(1000)
                            ->optionsLimit(20),
                        Forms\Components\Select::make('expediente_ciudadano_id')
                            ->label('Titular:')
                            ->relationship('ciudadano', 'nombre_completo')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->visible(function (Forms\Get $get) {
                                return $get('tipo_titular_id') == 1; // Visible cuando tipo_titular_id es igual a 2 CIUDADANOS
                            })
                            ->createOptionForm([
                                Forms\Components\Section::make('Añadir un nuevo Registro Ciudadano')
                                    ->schema([
                                        Forms\Components\TextInput::make('nombres')
                                            ->label('Nombres:')
                                            ->placeholder('Ej: JUAN GABRIEL')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                                $nombre = $get('nombres');
                                                $apellido = $get('apellidos');
                                                $nombre_completo =  $nombre . ' ' . $apellido;

                                                $set('nombre_completo', $nombre_completo);
                                            }),
                                        Forms\Components\TextInput::make('apellidos')
                                            ->label('Apellidos:')
                                            ->placeholder('Ej: PEREZ GAMARRA')
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                                $nombre = $get('nombres');
                                                $apellido = $get('apellidos');
                                                $nombre_completo =  $nombre . ' ' . $apellido;

                                                $set('nombre_completo', $nombre_completo);
                                            }),
                                        Forms\Components\Hidden::make('nombre_completo'),
                                        Forms\Components\TextInput::make('ci')
                                            ->label('CI:')
                                            ->placeholder('* Sin puntos ni comas Ej: 1234567')
                                            ->maxLength(15),
                                        Forms\Components\TextInput::make('ruc')
                                            ->placeholder('Ej: 1234567-8')
                                            ->label('RUC:')
                                            ->maxLength(15),
                                        Forms\Components\TextInput::make('telefono')
                                            ->label('N° Teléfono:')
                                            ->placeholder('Ej: 0984123456')
                                            ->maxLength(20),
                                        Forms\Components\TextInput::make('email')
                                            ->label('Correo:')
                                            ->placeholder('Ej: juanperez@gmail.com')
                                            ->maxLength(50),
                                        Forms\Components\TextInput::make('direccion_particular')
                                            ->label('Dirección Particular:')
                                            ->placeholder('Barrio, Calle')
                                            ->maxLength(255),
                                        Forms\Components\Select::make('ciudad_id')
                                            ->label('Ciudad:')
                                            ->relationship('ciudad', 'ciudad_nombre')
                                            ->searchable()
                                            ->preload(),
                                        Forms\Components\Select::make('tipo_persona')
                                            ->options([
                                                'PERSONA FÍSICA' => 'PERSONA FÍSICA',
                                                'PERSONA JURÍDICA' => 'PERSONA JURÍDICA',
                                            ]),
                                        Forms\Components\Hidden::make('creado_por')->default(auth()->id())
                                    ])->columns(3)
                            ]),

                        Forms\Components\Select::make('departamentosConCopia')
                            ->label('Con Copia a:')
                            ->multiple()
                            ->relationship('departamentosConCopia', 'departamento_nombre')
                            ->searchable()
                            ->preload(),
                        Forms\Components\Toggle::make('acceso_restringido')->default(false)
                            ->required()
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('expediente_asunto')
                    ->label('Asunto:')
                    ->limit('30')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('mesa_entrada_completa')
                    ->label('N° Mesa Entrada')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipoFuente.tipo_fuente')
                    ->label('Fuente:')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado.expediente_estado')
                    ->label('Estado:')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('departamento.departamento_nombre')
                    ->label('Ubicación:')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\TextColumn::make('ciudadano.nombre_completo')
                //     ->label('Responsable:')
                //     ->visible()
                //     ->searchable()
                //     ->sortable(),
                //  Tables\Columns\TextColumn::make('mostrarNombrePersonal') // Usa el método que has definido
                //      ->label('Responsable:')
                //      ->getStateUsing(fn($record) => $record->mostrarNombrePersonal()),
                // Tables\Columns\ColumnGroup::make('Responsable:', [
                //     Tables\Columns\TextColumn::make('mostrarNombrePersonal') // Usa el método que has definido
                //     ->label('')
                //     ->getStateUsing(fn($record) => $record->mostrarNombrePersonal()),
                //     Tables\Columns\TextColumn::make('ciudadano.nombre_completo')
                //         ->visible()
                //         ->label('')
                //         ->searchable()
                //         ->sortable(),
                // ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Ingreso')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //

                // FILTRAR POR ESTADO
                Tables\Filters\SelectFilter::make('expediente_estado_id')
                    ->label('Estado:')
                    ->options(function () {
                        return \App\Models\Expediente\Estado::pluck('expediente_estado', 'id_expediente_estado')->toArray();
                    })->preload(),

                // FILTRAR POR PRIORIDAD
                Tables\Filters\SelectFilter::make('tipo_fuente_id')
                    ->label('Fuente:')
                    ->options(function () {
                        return \App\Models\Expediente\TipoFuente::pluck('tipo_fuente', 'id_tipo_fuente')->toArray();
                    })->preload(),

                // FILTRAR POR UBICACION
                Tables\Filters\SelectFilter::make('expediente_departamento_id')
                    ->label('Ubicación:')
                    ->options(function () {
                        return \App\Models\Departamento::pluck('departamento_nombre', 'id_departamento')->toArray();
                    })->preload()->searchable(),

                // FILTRAR POR RESPONSABLE
                Tables\Filters\SelectFilter::make('expediente_ciudadano_id')
                    ->label('Responsable:')
                    ->options(function () {
                        return \App\Models\Ciudadano::pluck('nombre_completo', 'id_ciudadano')->toArray();
                    })->searchable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('aceptar')
                    ->visible(function (Expediente $record) {
                        return $record->estado->expediente_estado === 'DERIVADO';
                    })
                    ->requiresConfirmation()
                    ->action(function (Expediente $record) {
                        $usuario = Auth::user();
                        // Usar cache para el estado si se consulta frecuentemente
                        $estadoEnProgreso = cache()->remember('estado_en_progreso', 3600, function () {
                            return ExpedienteEstado::where('expediente_estado', 'EN PROGRESO')->first();
                        });
                        DB::transaction(function () use ($record, $estadoEnProgreso, $usuario) {
                            // Actualizar expediente y crear comentario en una sola transacción
                            $record->update([
                                'expediente_estado_id' => $estadoEnProgreso->id_expediente_estado,
                            ]);
                            ExpedienteComentario::create([
                                'expediente_comentario' => "{$usuario->name} aceptó la derivación del expediente al departamento",
                                'comentario_expediente_id' => $record->id_expediente,
                                'creador_usuario_id' => $usuario->id,
                            ]);
                        });
                    }),
                Tables\Actions\Action::make('rechazar')
                    ->visible(function (Expediente $record) {
                        return $record->estado->expediente_estado === 'DERIVADO';
                    })
                    ->form([
                        Forms\Components\Textarea::make('motivo')
                            ->label('Motivo del Rechazo')
                            ->required(),
                    ])
                    ->action(function (array $data, Expediente $record) {
                        $usuario = Auth::user();
                        $motivo = $data['motivo'];

                        // Obtener el último registro del historial para este expediente
                        $ultimaDerivacion = DepartamentoHistorial::where('expediente_id', $record->id_expediente)
                            ->latest()
                            ->first();
                        // Obtener los nombres de los departamentos para el mensaje
                        $departamentoActual = Departamento::find($record->expediente_departamento_id)->departamento_nombre;
                        $departamentoAnterior = Departamento::find($ultimaDerivacion->departamento_origen_id)->departamento_nombre;

                        // Obtener el estado en progreso
                        $estadoEnProgreso = ExpedienteEstado::where('expediente_estado', 'EN PROGRESO')->first();

                        DB::transaction(function () use ($record, $usuario, $motivo, $ultimaDerivacion, $departamentoActual, $departamentoAnterior, $estadoEnProgreso) {

                            // Registrar el rechazo en el historial
                            DepartamentoHistorial::create([
                                'expediente_id' => $record->id_expediente,
                                'departamento_origen_id' => $record->expediente_departamento_id,
                                'departamento_destino_id' => $ultimaDerivacion->departamento_origen_id,
                                'usuario_id' => $usuario->id,
                            ]);

                            // Actualizar el expediente al departamento anterior
                            $record->update([
                                'expediente_departamento_id' => $ultimaDerivacion->departamento_origen_id,
                                'expediente_estado_id' => $estadoEnProgreso->id_expediente_estado,
                            ]);



                            // Crear el comentario del rechazo
                            ExpedienteComentario::create([
                                'expediente_comentario' => "{$usuario->name} rechazó la derivación del expediente de {$departamentoActual} y lo devolvió a {$departamentoAnterior}. Motivo: {$motivo}",
                                'comentario_expediente_id' => $record->id_expediente,
                                'creador_usuario_id' => $usuario->id,
                            ]);
                        });

                        Notification::make()
                            ->title('Expediente rechazado')
                            ->body('El expediente ha sido devuelto al departamento anterior.')
                            ->success()
                            ->send();
                    })
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([5, 10, 15, 20])->defaultPaginationPageOption(5);
    }
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->select('id_expediente', 'expediente_asunto', 'mesa_entrada_completa', 'tipo_fuente_id', 'expediente_estado_id', 'expediente_departamento_id', 'expediente_ciudadano_id', 'personal_id', 'tit_compania_id', 'tit_departamento_id', 'agrego_usuario_id', 'created_at', 'updated_at')
            ->with(['estado', 'departamento', 'ciudadano', 'comentarios', 'tipoFuente', 'departamentoTitular', 'companiaTitular', 'personalTitular'])
            ->orderBy('mesa_entrada_completa', 'desc');

        $user = Auth::user();

        if (!$user->hasRole(['super_admin', 'mesa_de_entrada'])) {
            $query->where(function ($q) use ($user) {
                $q->where('expediente_departamento_id', $user->departamento_id)
                    ->orWhereIn('id_expediente', function ($subquery) use ($user) {
                        $subquery->select('expediente_id')
                            ->from('expedientes_departamentos_concopia')
                            ->where('departamento_id', $user->departamento_id);
                    });
            });
        }

        return $query;
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     $query = parent::getEloquentQuery()
    //         ->select('id_expediente', 'expediente_asunto', 'mesa_entrada_completa', 'expediente_estado_id', 'tipo_fuente_id', 'expediente_prioridad_id', 'expediente_departamento_id', 'expediente_ciudadano_id', 'personal_id', 'created_at', 'updated_at')
    //         //->with(['estado:id_expediente_estado, expediente_estado', 'prioridad:id_expediente_prioridad,expediente_prioridad', 'departamento:id_departamento, departamento_nombre', 'ciudadano:id_ciudadano, nombre_completo']);
    //         ->with(['estado', 'prioridad', 'departamento', 'ciudadano', 'comentarios', 'tipoFuente'])->orderBy('expediente_prioridad_id', 'desc')->orderBy('created_at', 'desc');

    //     $user = Auth::user();

    //     if (!$user->hasRole(['super_admin', 'mesa_de_entrada'])) {
    //         $query->where('expediente_departamento_id', $user->departamento_id);
    //     }

    //     return $query;
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExpedientes::route('/'),
            'create' => Pages\CreateExpediente::route('/create'),
            'view' => Pages\ViewExpediente::route('/{record}'),
            'edit' => Pages\EditExpediente::route('/{record}/edit'),
        ];
    }
}
