<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Widgets\AgreementReminderOverview;
use App\Filament\Admin\Widgets\AgreementStatsOverview;
use App\Filament\Admin\Widgets\PurchaseRequestApproveStats;
use App\Filament\Admin\Widgets\RecentActivityWidget;
use App\Filament\Widgets\SpkTeknisiStats;
use App\Http\Middleware\ForcePasswordChange;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Enums\ThemeMode;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Heyosseus\Filum\FilumPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Zvizvi\FilamentColumnFilters\FilamentColumnFiltersPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->defaultThemeMode(ThemeMode::Light)
            // ->login()
            ->login(\App\Filament\Admin\Pages\Auth\Login::class)
            ->brandLogo(fn () => view('filament.admin.logo'))            
            ->favicon(asset('images/logo_32.png'))
            // ->brandLogoHeight('2rem')         
            ->colors([
                'primary' => Color::Amber,
            ])
            ->sidebarFullyCollapsibleOnDesktop()
            ->maxContentWidth(Width::Full)
            ->sidebarWidth('17rem') 
            ->collapsedSidebarWidth('4rem')
            ->spa()
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->navigationGroups([
                'Agreements',
                'Purchasing',
                'Setting',
                'CRM',
            ])            // ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
                // AgreementTypeChart::class,
                AgreementStatsOverview::class,
                AgreementReminderOverview::class,
                RecentActivityWidget::class,
                PurchaseRequestApproveStats::class,
                SpkTeknisiStats::class])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                ForcePasswordChange::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
                FilamentColumnFiltersPlugin::make(),
                FilumPlugin::make(),
            ])
            ;
    }
}
