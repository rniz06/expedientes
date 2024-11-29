<?php

namespace App\Filament\Widgets;

use App\Models\Expediente;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsuarisContador extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //Contador de usuarios
            Stat::make('', User::query()->count())
            ->description('Total De Usuarios')
            ->descriptionIcon('heroicon-o-user-group', IconPosition::Before),

            // Contador de expedientes
            Stat::make('', Expediente::query()->count())
            ->description('Total De Expedientes')
            ->descriptionIcon('heroicon-o-folder', IconPosition::Before),
        ];
    }
}
