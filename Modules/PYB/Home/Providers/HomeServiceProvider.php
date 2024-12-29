<?php

namespace PYB\Home\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use PYB\Category\Repositories\CategoryRepo;

class HomeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views/', 'Home');
//        $this->loadRoutesFrom(__DIR__ . '/../Routes/home_routes.php');
        Route::middleware('web')->namespace('PYB\Home\Http\Controllers')->group(__DIR__ . '/../Routes/home_routes.php');
    }

    public function boot()
    {
        view()->composer(['Home::section.footer', 'Home::section.header'], static function ($view) {
            $categoryRepo = new CategoryRepo;
            $categories = $categoryRepo->getActiveCategories()->get();

            $view->with(['categories' => $categories]);
        });



        config()->set('panelConfig.menus.home', [
            'url'   => route('home.index'),
            'title' => 'سایت اصلی',
            'icon'  => 'home',
        ]);
    }
}
