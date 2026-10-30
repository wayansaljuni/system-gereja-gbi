<?php

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
// use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Schema::defaultStringLength(191);
        $this->app->bind(
            LogoutResponseContract::class,
            LogoutResponse::class,
        ); 
    }    

    public function boot(): void
    {
        // Schema::defaultStringLength(191);       
        Event::listen(Login::class, function (Login $event): void {
            $user = $event->user;
            if (! $user instanceof Model) {
                return;
            }
            activity('authentication')
                ->causedBy($user)
                ->event('login')
                ->withProperties([
                    'guard' => $event->guard,
                    'ip' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ])
                ->log('Login ke aplikasi');                    //
        });
        
        // FilamentView::registerRenderHook(
        //     PanelsRenderHook::HEAD_END,
        //     fn () => Blade::render(<<<'HTML'
        //         <style>
        //             div:has(> .rekap-sticky) { position: sticky; top: 4rem; z-index: 30; }
        //             .rekap-sticky { background: #fff; padding-bottom: .5rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / .1); }
        //             .dark .rekap-sticky { background: rgb(var(--gray-950)); }
        //         </style>
        //     HTML),
        // );        

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     Schema::defaultStringLength(191);
    // }
    }
}
