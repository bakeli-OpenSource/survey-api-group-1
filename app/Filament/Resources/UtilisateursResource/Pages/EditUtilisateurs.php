<?php

namespace App\Filament\Resources\UtilisateursResource\Pages;

use App\Filament\Resources\UtilisateursResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUtilisateurs extends EditRecord
{
    protected static string $resource = UtilisateursResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
