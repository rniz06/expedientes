<?php

namespace App\Filament\Resources\CiudadanoResource\Pages;

use App\Filament\Resources\CiudadanoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCiudadano extends CreateRecord
{
    protected static string $resource = CiudadanoResource::class;

    protected static ?string $title = 'Añadir Ciudadano';

    protected function getRedirectUrl(): string
    {
        return CiudadanoResource::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nombre_completo'] = $data['nombres'] . ' ' . $data['apellidos'];

        $data['creado_por'] = auth()->id();

        return $data;
    }
}
