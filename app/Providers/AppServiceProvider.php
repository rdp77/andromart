<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Employee;
use App\Models\Service;
use Auth;
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
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $chekSales = Employee::with('Service1','Service2')->get();
                $total = [];
                for ($i=0; $i <count($chekSales) ; $i++) { 
                    $sharingProfit1[$i] = Service::with(['ServiceDetail','ServiceDetail.Items','ServiceStatusMutation','ServiceStatusMutation.Technician','SharingProfitDetail','SharingProfitDetail.SharingProfit'])
                    // ->whereBetween('date', [$this->DashboarController->changeMonthIdToEn($req->dateS), $this->DashboardController->changeMonthIdToEn($req->dateE)])
                    ->where('work_status','Diambil')
                    ->where('payment_status','Lunas')
                    ->where('technician_id',$chekSales[$i]->id)
                    ->sum('sharing_profit_technician_1');
                    $sharingProfit2[$i] = Service::with(['ServiceDetail','ServiceDetail.Items','ServiceStatusMutation','ServiceStatusMutation.Technician','SharingProfitDetail','SharingProfitDetail.SharingProfit'])
                    // ->whereBetween('date', [$this->DashboardController->changeMonthIdToEn($req->dateS), $this->DashboardController->changeMonthIdToEn($req->dateE)])
                    ->where('work_status','Diambil')
                    ->where('payment_status','Lunas')
                    ->where('technician_replacement_id',$chekSales[$i]->id)
                    ->sum('sharing_profit_technician_2');
                }
                    
              
                $view->with(['sharingProfit' => $chekSales,'sharingProfit1'=>$sharingProfit1,
                'sharingProfit2'=>$sharingProfit2,]);
            }
        });
    }
}
