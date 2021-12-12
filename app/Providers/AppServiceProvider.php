<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        if (Schema::hasTable('menu') and Schema::hasTable('submenu') and Schema::hasTable('roles_detail')) {
            View::share('menu', Menu::with('SubMenu', 'SubMenu.RoleDetail')->get());
        }
        view()->composer('*', function ($view) {
            if (Auth::check()) {

                // $view->with([
                //     'sharingProfit' => $chekSales, 'sharingProfit1' => $sharingProfit1,
                //     'sharingProfit2' => $sharingProfit2,
                // ]);
                // return [$chekSales,$sharingProfit1,$sharingProfit2];
            }
        });
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');
    }
}