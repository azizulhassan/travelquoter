<?php

namespace App\Filament\Admin\Resources\AirlineResource\Pages;

use App\Filament\Admin\Resources\AirlineResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAirline extends ViewRecord
{
    protected static string $resource = AirlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
