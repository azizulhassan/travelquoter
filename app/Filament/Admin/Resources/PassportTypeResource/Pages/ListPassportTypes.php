<?php

namespace App\Filament\Admin\Resources\PassportTypeResource\Pages;

use App\Filament\Admin\Resources\PassportTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPassportTypes extends ListRecords
{
    protected static string $resource = PassportTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
