<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Resources\TicketResource;
use App\Filament\Resources\LogActivityResource;

use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;


use Filament\Facades\Filament;
use Filament\Forms\Components\View;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login;


class AdminPanelProvider extends PanelProvider
{

    
        


    public function panel(Panel $panel): Panel
    {
        return $panel->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
                
            ])

            
             //🔹 Tambahkan Branding (Logo & Nama)
            //  ->brandLogo(asset('images/Capture-removebg-preview.png')) // ✅ Logo lebih besar
            // ->brandLogoHeight('60px') // ✅ Tinggi logo lebih besar
            ->brandName('FTTH JELANTIK HELPDESK') // ✅ Pastikan nama tetap ada
            ->resources([
                TicketResource::class,
            ])
            
            

            // 🔥 Tambahkan Resources secara eksplisit
            ->resources([
                TicketResource::class,
            ])

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
                // \App\Filament\Pages\TicketBackbone::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ]);
    }
}