<?php

namespace App\Filament\Admin\Resources\BedTypeResource\Pages;

use App\Filament\Admin\Resources\BedTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBedType extends ViewRecord
{
    protected static string $resource = BedTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
