<?php

namespace App\Filament\Admin\Resources\AmenityResource\Pages;

use App\Filament\Admin\Resources\AmenityResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAmenity extends ViewRecord
{
    protected static string $resource = AmenityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
