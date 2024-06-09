<?php

namespace App\Filament\Admin\Resources\StoryTagResource\Pages;

use App\Filament\Admin\Resources\StoryTagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStoryTags extends ListRecords
{
    protected static string $resource = StoryTagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
