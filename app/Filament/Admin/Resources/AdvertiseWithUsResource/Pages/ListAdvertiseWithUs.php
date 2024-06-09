<?php

namespace App\Filament\Admin\Resources\AdvertiseWithUsResource\Pages;

use App\Filament\Admin\Resources\AdvertiseWithUsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvertiseWithUs extends ListRecords
{
    protected static string $resource = AdvertiseWithUsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
