<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Paytm;
use Illuminate\Support\Facades\Config;

class PaytmConfigProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $paytmDetails=paytm::latest()->first();
        // if(!is_null($paytmDetails)) {
        //     $config = array(
        //         'env'               =>  $paytmDetails->paytm_environment,
        //         'merchant_id'       =>  $paytmDetails->paytm_merchant_id,
        //         'merchant_key'      =>  $paytmDetails->paytm_merchant_key,
        //         'merchant_website'  =>  $paytmDetails->paytm_merchant_website,
        //         'channel'           =>  $paytmDetails->paytm_channel ,
        //         'industry_type'     =>  $paytmDetails->paytm_industry_type,
        //     );
        //     Config::set('services.paytm-wallet', $config);
        // }
    }
}