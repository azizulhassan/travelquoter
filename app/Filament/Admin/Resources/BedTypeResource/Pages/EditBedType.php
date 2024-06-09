<?php

namespace App\Filament\Admin\Resources\BedTypeResource\Pages;

use App\Filament\Admin\Resources\BedTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBedType extends EditRecord
{
    protected static string $resource = BedTypeResource::class;

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
