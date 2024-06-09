<?php

namespace App\Filament\Admin\Resources\FlightClassResource\Pages;

use App\Filament\Admin\Resources\FlightClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFlightClass extends ViewRecord
{
    protected static string $resource = FlightClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
