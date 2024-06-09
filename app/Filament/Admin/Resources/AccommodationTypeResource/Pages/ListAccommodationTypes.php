<?php

namespace App\Filament\Admin\Resources\AccommodationTypeResource\Pages;

use App\Filament\Admin\Resources\AccommodationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAccommodationTypes extends ListRecords
{
    protected static string $resource = AccommodationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
