<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Andreia\FilamentNordTheme\FilamentNordThemePlugin;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Client\Widgets\DealsWidget;
use App\Filament\Widgets\DealsValuePerMonth;
use App\Filament\Widgets\ProjectsWidget;
use App\Filament\Client\Widgets\LeadsWidget;
use Filament\Enums\ThemeMode;

// Login Verification
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

// Plugins
use Filafly\Themes\Brisk\BriskTheme;
use Swis\Filament\Backgrounds\FilamentBackgroundsPlugin;
use Swis\Filament\Backgrounds\ImageProviders\MyImages;
use Caresome\FilamentNeobrutalism\NeobrutalismeTheme;

class ClientPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('client')
            ->path('client')
            ->sidebarCollapsibleOnDesktop()
            ->viteTheme('resources/css/filament/client/theme.css')
            ->plugins([
                BriskTheme::make(),
                FilamentBackgroundsPlugin::make()
                    ->imageProvider(
                        MyImages::make()
                            ->directory('images/backgrounds/filament-client')
                    ),
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                LeadsWidget::class,
                DealsWidget::class,
                DealsValuePerMonth::class,
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
            ])
            ->authMiddleware([]);
    }
    protected function getWidgets(): array
    {
        return [
        ];
    }

    // Only Allow Certain Users
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->isAdmin; 
        }

        if ($panel->getId() === 'client') {
            return true; 
        }

        return false;
    }
}
