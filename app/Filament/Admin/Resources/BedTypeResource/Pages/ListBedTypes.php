<?php

namespace App\Filament\Admin\Resources\BedTypeResource\Pages;

use App\Filament\Admin\Resources\BedTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBedTypes extends ListRecords
{
    protected static string $resource = BedTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
