<?php

namespace App\Filament\Admin\Resources\CarTypeResource\Pages;

use App\Filament\Admin\Resources\CarTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCarType extends ViewRecord
{
    protected static string $resource = CarTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
