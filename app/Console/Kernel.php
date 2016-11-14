<?php

namespace App\Console;

Use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\ListingExpired::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();

        $schedule->command('ListingExpired')
                 ->everyMinute();
    }

    /*protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            /*$listings = Listing::table('listings')->select('id', 'custtomer_id', 'listing_id', 'expired_date')->get();
            foreach ($listings as $listing) {
                   if ($listing->expired_date > Carbon::now() ) {
                       Listing::table('Listings')
                            ->where('listing_id', $listing->listing_id)
                            ->update(['status' => 5]);
                   }
               }
        })->everyMinute();
    }*/
}