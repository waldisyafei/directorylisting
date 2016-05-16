<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Listing;
use App\Models\Ad;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $listings = Listing::where('status', array(3, 5))->get();

        if ($listings) {
            foreach ($listings as $listing) {
                $expired_datetime = $listing->expired_date;
                $expired_time = strtotime($expired_datetime);
                $now_time = time();

                if ($now_time >= $expired_time) {
                    $listing->status = 5;

                    $listing->save();
                }
            }
        }

        $ads = Ad::where('status', 3)->get();

        if ($ads) {
            foreach ($ads as $ad) {
                $expired_date = $ad->expired_date;
                $expired_time = strtotime($expired_date);
                $now_time = time();

                if ($now_time >= $expired_time) {
                    $ad->status = 5;
                    $ad->save();
                }
            }
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
