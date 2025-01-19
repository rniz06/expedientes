<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CiudadanoResource\Pages;
use App\Filament\Resources\CiudadanoResource\RelationManagers;
use App\Models\Ciudadano;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CiudadanoResource extends Resource
{
    protected static ?string $model = Ciudadano::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('nombres')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('apellidos')
                            ->maxLength(50),
                        Forms\Components\TextInput::make('ci')
                            ->required()
                            ->maxLength(15),
                        Forms\Components\TextInput::make('ruc')
                            ->maxLength(20)
                            ->default(null),
                        Forms\Components\TextInput::make('telefono')
                            ->tel()
                            ->maxLength(20)
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(50)
                            ->default(null),
                        Forms\Components\TextInput::make('direccion_particular')
                            ->maxLength(70)
                            ->required(),
                        Forms\Components\Select::make('tipo_persona')
                            ->options([
                                'PERSONA FÍSICA' => 'PERSONA FÍSICA',
                                'PERSONA JURÍDICA' => 'PERSONA JURÍDICA',
                            ])->default('PERSONA FÍSICA')
                            ->required(),
                        Forms\Components\Select::make('ciudad_id')
                            ->label('Ciudad')
                            ->relationship('ciudad', 'ciudad_nombre')
                            ->preload()
                            ->searchable()
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ci')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ruc')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('telefono')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('direccion_particular')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipo_persona')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ciudad.ciudad_nombre')
                    ->badge()
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
                // FILTRAR POR TIPO PERSONA
                Tables\Filters\SelectFilter::make('tipo_persona')
                    ->label('Tipo Persona:')
                    ->options([
                        'PERSONA FÍSICA' => 'PERSONA FÍSICA',
                        'PERSONA JURÍDICA' => 'PERSONA JURÍDICA',
                    ]),

                // FILTRAR POR CIUDAD
                Tables\Filters\SelectFilter::make('ciudad_id')
                    ->label('Ciudad:')
                    ->options(function () {
                        return \App\Models\Ciudad::pluck('ciudad_nombre', 'id_ciudad')->toArray();
                    })->searchable()->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->paginated([5, 10, 15, 20, 25])->defaultPaginationPageOption(5);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select('id_ciudadano', 'nombres', 'apellidos', 'nombre_completo', 'ci', 'ruc', 'telefono', 'email', 'direccion_particular', 'tipo_persona', 'barrio_id', 'ciudad_id')
            ->with(['barrio:id_barrio,barrio_nombre', 'ciudad:id_ciudad,ciudad_nombre']);
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
            'index' => Pages\ListCiudadanos::route('/'),
            'create' => Pages\CreateCiudadano::route('/create'),
            'edit' => Pages\EditCiudadano::route('/{record}/edit'),
        ];
    }
}
