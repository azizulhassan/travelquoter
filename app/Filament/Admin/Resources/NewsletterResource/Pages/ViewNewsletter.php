<?php

namespace App\Filament\Admin\Resources\NewsletterResource\Pages;

use App\Filament\Admin\Resources\NewsletterResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewNewsletter extends ViewRecord
{
    protected static string $resource = NewsletterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
