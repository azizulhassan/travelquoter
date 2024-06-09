<?php

namespace App\Filament\Admin\Resources\AdvertiseWithUsResource\Pages;

use App\Filament\Admin\Resources\AdvertiseWithUsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdvertiseWithUs extends EditRecord
{
    protected static string $resource = AdvertiseWithUsResource::class;

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
