<?php

namespace App\Filament\Admin\Resources\PassportTypeResource\Pages;

use App\Filament\Admin\Resources\PassportTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPassportType extends ViewRecord
{
    protected static string $resource = PassportTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
