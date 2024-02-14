<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Utilisateurs', User::query()->count())
            ->description('Nombre d\'utilisateurs inscrits')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        Stat::make('Sondages', Post::query()->count())
            ->description('Nombre de sondages crees')
            ->descriptionIcon('heroicon-m-arrow-trending-down')
            ->color('danger'),
        Stat::make('Sondages Partages', '1')
            ->description('')
            ->description('Nombres de sondages partages')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success'),

        ];
    }
}
