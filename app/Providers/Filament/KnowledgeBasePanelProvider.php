<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
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
use Guava\FilamentKnowledgeBase\Plugins\KnowledgeBasePlugin;
use App\Http\Middleware\CheckUserApproved;
use App\Http\Middleware\CheckCanAccessKnowledgeBase;

class KnowledgeBasePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('knowledge-base')
            ->path('knowledge-base')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->plugins([
                KnowledgeBasePlugin::make(),
            ])
            ->discoverResources(in: app_path('Filament/KnowledgeBase/Resources'), for: 'App\Filament\KnowledgeBase\Resources')
            ->discoverPages(in: app_path('Filament/KnowledgeBase/Pages'), for: 'App\Filament\KnowledgeBase\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/KnowledgeBase/Widgets'), for: 'App\Filament\KnowledgeBase\Widgets')
            ->widgets([
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
            ->authMiddleware([
                Authenticate::class,
                CheckCanAccessKnowledgeBase::class,
            ]);
    }
}
