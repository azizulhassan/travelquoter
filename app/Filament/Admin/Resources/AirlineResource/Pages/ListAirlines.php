<?php

namespace App\Filament\Admin\Resources\AirlineResource\Pages;

use App\Filament\Admin\Resources\AirlineResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAirlines extends ListRecords
{
    protected static string $resource = AirlineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
