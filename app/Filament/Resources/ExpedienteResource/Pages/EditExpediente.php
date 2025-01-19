<?php

namespace App\Filament\Resources\ExpedienteResource\Pages;

use App\Filament\Resources\ExpedienteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpediente extends EditRecord
{
    protected static string $resource = ExpedienteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //Actions\DeleteAction::make(),
        ];
    }

    // REDIRECCIONAR AL INDEX LUEGO DE ACTUALIZAR UN REGISTRO
    protected function getRedirectUrl(): string
    {
        return ExpedienteResource::getUrl('index');
    }
}
