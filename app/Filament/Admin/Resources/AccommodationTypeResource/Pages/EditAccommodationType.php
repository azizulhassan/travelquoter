<?php

namespace App\Filament\Admin\Resources\AccommodationTypeResource\Pages;

use App\Filament\Admin\Resources\AccommodationTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAccommodationType extends EditRecord
{
    protected static string $resource = AccommodationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
