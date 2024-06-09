<?php

namespace App\Filament\Admin\Resources\AdvertiseWithUsResource\Pages;

use App\Filament\Admin\Resources\AdvertiseWithUsResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAdvertiseWithUs extends ViewRecord
{
    protected static string $resource = AdvertiseWithUsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
