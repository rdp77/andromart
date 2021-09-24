<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Employee;
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
                // $totalss = 0;
                for ($i=0; $i <count($chekSales) ; $i++) { 
                    $total[$i]  = 0;
                    if($chekSales[$i]->Service1 != null){
                        for ($j=0; $j <count($chekSales[$i]->Service1) ; $j++) { 
                            if($chekSales[$i]->id == $chekSales[$i]->Service1[$j]->technician_id){
                                $total[$i] = $chekSales[$i]->Service1[$j]->sharing_profit_technician_1;
                            }
                        }
                    }
                        
                    // }else if($chekSales[$i]->Service1 == null){
                    //     $total[$i]  = 0;
                    // }
                    // if($chekSales[$i]->Service2 != null){
                        // for ($j=0; $j <count($chekSales[$i]->Service2) ; $j++) { 
                            // $total[$i] = $chekSales[$i]->Service2[$j]->sharing_profit_technician_2;
                        // }
                    // }else if($chekSales[$i]->Service2 == null){
                    //     $total[$i]  = 0;
                    // }
                }

                // dd($chekSales);
                dd($total);
                // return $total;
                // $date = date('Y-m-d');
                // $dayofweek = date('w', strtotime($date));
                // $result    = date('Y-m-d', strtotime(($day - $dayofweek).' day', strtotime($date)));
                $view->with(['sharingProfit' => $chekSales,'total'=>$total]);
            }
        });
    }
}
