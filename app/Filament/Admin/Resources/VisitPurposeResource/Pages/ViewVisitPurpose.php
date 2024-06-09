<?php

namespace App\Filament\Admin\Resources\VisitPurposeResource\Pages;

use App\Filament\Admin\Resources\VisitPurposeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVisitPurpose extends ViewRecord
{
    protected static string $resource = VisitPurposeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
