<?php

namespace App\Filament\Resources\UtilisateursResource\Pages;

use App\Filament\Resources\UtilisateursResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUtilisateurs extends ListRecords
{
    protected static string $resource = UtilisateursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
