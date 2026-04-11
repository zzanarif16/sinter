<?php

namespace App\Filament\Resources\Inspirations\Pages;

use App\Filament\Resources\Inspirations\InspirationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInspiration extends ViewRecord
{
    protected static string $resource = InspirationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
