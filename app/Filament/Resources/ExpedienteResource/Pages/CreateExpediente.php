<?php

namespace App\Filament\Resources\ExpedienteResource\Pages;

use App\Filament\Resources\ExpedienteResource;
use App\Models\Departamento;
use App\Models\Expediente\Estado as ExpedienteEstado;
use App\Models\Expediente\TipoGestion;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateExpediente extends CreateRecord
{
    protected static string $resource = ExpedienteResource::class;

    protected static ?string $title = 'Añadir Expediente';

    protected function getRedirectUrl(): string
    {
        return ExpedienteResource::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {

        $recien_ingresado_id = ExpedienteEstado::where('expediente_estado', 'EN PROGRESO')->first();

        $secretaria_nacional_id = Departamento::where('departamento_nombre', 'SECRETARIA NACIONAL')->first();

        // Elimina los primeros 10 caracteres (CBVP-2024-)
        $data['nro_mesa_entrada'] = substr($data['mesa_entrada_completa'], 10);

        // Elimina los primeros 5 caracteres (CBVP-), dejando '2024-00001'
        $data['nro_mesa_entrada_anho'] = substr($data['mesa_entrada_completa'], 5);

        // Extrae solo el año (del índice 5 al 8, en este caso '2024')
        $data['mesa_entrada_anho'] = substr($data['mesa_entrada_completa'], 5, 4);

        // Obtiene el prefijo y el año (CBVP-2024)
        $data['mesa_entrada_prefix_anho'] = substr($data['mesa_entrada_completa'], 0, 9);

        $data['expediente_estado_id'] = $recien_ingresado_id->id_expediente_estado;

        $data['expediente_departamento_id'] = $secretaria_nacional_id->id_departamento;

        // Elimina los primeros 10 caracteres (CBVP-2024-)
        $data['agrego_usuario_id'] = Auth::id();

        return $data;
    }
}
