<?php

namespace App\Filament\Admin\Resources\CruiseAdditionalInfoResource\Pages;

use App\Filament\Admin\Resources\CruiseAdditionalInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCruiseAdditionalInfos extends ListRecords
{
    protected static string $resource = CruiseAdditionalInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
