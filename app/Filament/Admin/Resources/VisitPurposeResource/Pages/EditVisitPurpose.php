<?php

namespace App\Filament\Admin\Resources\VisitPurposeResource\Pages;

use App\Filament\Admin\Resources\VisitPurposeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVisitPurpose extends EditRecord
{
    protected static string $resource = VisitPurposeResource::class;

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
