<?php

namespace App\Filament\Admin\Resources\CruiseAdditionalInfoResource\Pages;

use App\Filament\Admin\Resources\CruiseAdditionalInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCruiseAdditionalInfo extends EditRecord
{
    protected static string $resource = CruiseAdditionalInfoResource::class;

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
