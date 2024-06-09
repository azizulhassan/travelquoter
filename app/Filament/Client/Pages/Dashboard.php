<?php

namespace App\Filament\Client\Pages;

use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.client.pages.dashboard';

    protected static ?int $navigationSort = -199;
}
