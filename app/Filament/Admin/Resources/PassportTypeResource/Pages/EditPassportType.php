<?php

namespace App\Filament\Admin\Resources\PassportTypeResource\Pages;

use App\Filament\Admin\Resources\PassportTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPassportType extends EditRecord
{
    protected static string $resource = PassportTypeResource::class;

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
