<?php

namespace App\Filament\Resources\SondagesResource\Pages;

use App\Filament\Resources\SondagesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSondages extends ListRecords
{
    protected static string $resource = SondagesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
