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

    protected function getRedirectUrl(): string
    {
        return CiudadanoResource::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['nombre_completo'] = $data['nombres'] . ' ' . $data['apellidos'];

        $data['actualizado_por'] = auth()->id();

        return $data;
    }
}
