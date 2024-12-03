<?php

namespace App\Filament\Resources\CiudadanoResource\Pages;

use App\Filament\Resources\CiudadanoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCiudadano extends EditRecord
{
    protected static string $resource = CiudadanoResource::class;

    protected static ?string $title = 'Editar Ciudadano';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
