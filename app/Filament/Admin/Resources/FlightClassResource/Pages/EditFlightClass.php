<?php

namespace App\Filament\Admin\Resources\FlightClassResource\Pages;

use App\Filament\Admin\Resources\FlightClassResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlightClass extends EditRecord
{
    protected static string $resource = FlightClassResource::class;

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
