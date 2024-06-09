<?php

namespace App\Providers\Filament;

use App\Filament\Client\Pages\Dashboard;
use App\Http\Middleware\IsClientEmailVerifiedMiddleware;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class ClientPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('client')
            ->authGuard('client')
            ->path('client')
            ->login()
            ->colors([
                'primary' => '#013663',
            ])
            ->discoverResources(in: app_path('Filament/Client/Resources'), for: 'App\\Filament\\Client\\Resources')
            ->discoverPages(in: app_path('Filament/Client/Pages'), for: 'App\\Filament\\Client\\Pages')
            ->pages([
                // Pages\Dashboard::class,
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Client/Widgets'), for: 'App\\Filament\\Client\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,

                IsClientEmailVerifiedMiddleware::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->font('Montserrat')
            // ->databaseNotifications()
            ->darkMode(false)
            // ->profile()
            ->topNavigation(true)
            ->passwordReset()
            ->favicon(asset('images/favicon.png'))
            ->brandLogo(asset('images/logo.png'))
            ->viteTheme('resources/css/filament/admin/theme.css')->navigationItems([
                NavigationItem::make('Home')->url('/')->icon('heroicon-o-link'),
                NavigationItem::make('Travel Alerts')->url('/alerts')->icon('heroicon-o-link'),
                NavigationItem::make('Offers')->url('/offers')->icon('heroicon-o-link'),
                NavigationItem::make('About Us')->url('/about-us')->icon('heroicon-o-link'),
                NavigationItem::make('Contact Us')->url('/contact-us')->icon('heroicon-o-link'),
            ])
            ->databaseNotifications();
    }
}
