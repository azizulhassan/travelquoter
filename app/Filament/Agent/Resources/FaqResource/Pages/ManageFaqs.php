<?php

namespace App\Filament\Agent\Resources\FaqResource\Pages;

use App\Filament\Agent\Resources\FaqResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFaqs extends ManageRecords
{
    protected static string $resource = FaqResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__('Add Faq'))->icon('heroicon-o-plus'),
        ];
    }
}
