<?php

namespace PYB\Panel\Providers;

use PYB\Panel\Models\Panel;
use Mlk\Panel\Policies\PanelPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class PanelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views/', 'Panel');
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'panel');
        Route::middleware('web')->namespace('PYB\Panel\Http\Controllers')->group(__DIR__ . '/../Routes/panel_routes.php');
        Gate::policy(Panel::class, PanelPolicy::class);


    }

    public function boot()
    {
        $this->app->booted(static function () {
            config()->set('panelConfig.menus.panel', [
                'url'   => route('panel.index'),
                'title' => 'پنل کاربری',
                'icon'  => 'view-dashboard',
            ]);
        });
    }
}
