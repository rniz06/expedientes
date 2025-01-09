<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpedienteResource\Pages;
use App\Filament\Resources\ExpedienteResource\RelationManagers;
use App\Models\Expediente;
use App\Models\Expediente\Comentario;
use App\Models\Expediente\Prioridad as ExpedientePrioridad;
use App\Models\Expediente\TipoFuente;
use App\Models\Expediente\TipoGestion;
use App\Services\Expediente\NroMesaEntradaGenerador;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

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
                            ->columnSpan(2)
                            ->live()
                            ->required(),
                    ]),
                Forms\Components\Section::make()
                    ->schema([

                        Forms\Components\TextInput::make('expediente_asunto')
                            ->label('Asunto:')
                            ->required()
                            ->visible(function (Forms\Get $get) {
                                return $get('tipo_fuente_id') == 2; // Visible cuando es EXTERNA
                            })
                            ->requiredIf('tipo_fuente_id', 2)
                            ->maxLength(255),
                        Forms\Components\Select::make('tipo_gestion_id')
                            ->label('Asunto:')
                            ->options(TipoGestion::all()->mapWithKeys(function ($tipoGestion) {
                                // Construir la opción combinada
                                $label = $tipoGestion->tipo_gestion;
                                // Si 'descripcion' no es null, agregarla entre paréntesis
                                if ($tipoGestion->descripcion) {
                                    $label .= ' (' . $tipoGestion->descripcion . ')';
                                }
                                return [$tipoGestion->id_tipo_gestion => $label];
                            }))
                            ->visible(function (Forms\Get $get) {
                                return $get('tipo_fuente_id') == 1; // Visible cuando es INTERNA
                            })
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                if ($get('tipo_fuente_id') == 1 && $state) { // Si es INTERNA y hay un valor seleccionado
                                    // Obtener el TipoGestion seleccionado
                                    $tipoGestion = TipoGestion::find($state);
                                    if ($tipoGestion) {
                                        // Construir el texto del asunto
                                        $asunto = $tipoGestion->tipo_gestion;
                                        if ($tipoGestion->descripcion) {
                                            $asunto .= ' (' . $tipoGestion->descripcion . ')';
                                        }
                                        // Actualizar el campo expediente_asunto
                                        $set('expediente_asunto', $asunto);
                                    }
                                }
                            })
                            ->required(),
                        Forms\Components\TextInput::make('mesa_entrada_completa')
                            ->label('N° Mesa de Entrada')
                            //->default(fn() => static::nroMesaEntradaGenerador())
                            ->default(NroMesaEntradaGenerador::nroMesaEntradaGenerador())
                            ->required()
                            ->maxLength(20)
                            ->readOnly(),
                        // Forms\Components\Select::make('expediente_estado_id')
                        //     ->label('Estado:')
                        //     ->relationship('estado', 'expediente_estado')
                        //     ->required(),
                        Forms\Components\Select::make('expediente_prioridad_id')
                            ->label('Nivel de Prioridad:')
                            ->relationship('prioridad', 'expediente_prioridad')
                            ->optionsLimit(15)
                            ->required(),
                        // Forms\Components\Select::make('expediente_departamento_id')
                        //     ->label('Departamento:')
                        //     ->relationship('departamento', 'departamento_nombre')
                        //     ->searchable()
                        //     ->preload()
                        //     ->required(),
                        Forms\Components\Select::make('expediente_ciudadano_id')
                            ->label('Responsable:')
                            ->relationship('ciudadano', 'nombre_completo')
                            ->searchable()
                            ->preload()
                            ->required()
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
                                            ->required()
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
                                            ->required()
                                            ->maxLength(15),
                                        Forms\Components\TextInput::make('ruc')
                                            ->placeholder('Ej: 1234567-8')
                                            ->label('RUC:')
                                            ->maxLength(15),
                                        Forms\Components\TextInput::make('telefono')
                                            ->label('N° Teléfono:')
                                            ->placeholder('Ej: 0984123456')
                                            ->required()
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
                                            ->preload()
                                            ->required(),
                                        Forms\Components\Select::make('tipo_persona')
                                            ->options([
                                                'PERSONA FÍSICA' => 'PERSONA FÍSICA',
                                                'PERSONA JURÍDICA' => 'PERSONA JURÍDICA',
                                            ])
                                            ->required(),
                                        Forms\Components\Hidden::make('creado_por')->default(auth()->id())
                                    ])->columns(3)
                            ]),
                        //Forms\Components\Toggle::make('acceso_restringido')->default(false)
                        //    ->required(),
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
                Tables\Columns\TextColumn::make('estado.expediente_estado')
                    ->label('Estado:')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prioridad.expediente_prioridad')
                    ->label('Prioridad:')
                    ->badge()
                    ->colors([
                        'secondary' => 'BAJO',
                        'success' => 'MEDIO',
                        'warning' => 'ALTO',
                        'danger' => 'URGENTE',
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('departamento.departamento_nombre')
                    ->label('Ubicación:')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ciudadano.nombre_completo')
                    ->label('Responsable:')
                    ->searchable()
                    ->sortable(),
                // Tables\Columns\IconColumn::make('acceso_restringido')
                //     ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha Ingreso')
                    ->dateTime()
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('expediente_prioridad_id')
                    ->label('Prioridad:')
                    ->options(function () {
                        return \App\Models\Expediente\Prioridad::pluck('expediente_prioridad', 'id_expediente_prioridad')->toArray();
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([5, 10, 15, 20])->defaultPaginationPageOption(5);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->select('id_expediente', 'expediente_asunto', 'mesa_entrada_completa', 'expediente_estado_id', 'expediente_prioridad_id', 'expediente_departamento_id', 'expediente_ciudadano_id', 'created_at', 'updated_at')
            //->with(['estado:id_expediente_estado, expediente_estado', 'prioridad:id_expediente_prioridad,expediente_prioridad', 'departamento:id_departamento, departamento_nombre', 'ciudadano:id_ciudadano, nombre_completo']);
            ->with(['estado', 'prioridad', 'departamento', 'ciudadano', 'comentarios'])->orderBy('created_at', 'desc');

        $user = Auth::user();

        // if (!$user->hasRole('super_admin')) {
        //     $query->where('departamento_id', $user->departamento_id);
        // }

        return $query;
    }

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
