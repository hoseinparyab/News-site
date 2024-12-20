<?php
namespace PYB\User\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views/', 'User');
        Route::middleware('web')->namespace('PYB\User\Http\Controllers')->group(__DIR__ . '/../Routes/user_routes.php');
    }
    public function boot()
    {
        $this->app->booted(static function () {
            config()->set('panelConfig.menus.users', [
                'url'   => route('users.index'),
                'title' => 'کاربران ',
                'icon'  => 'account',
            ]);
        });
    }

}
