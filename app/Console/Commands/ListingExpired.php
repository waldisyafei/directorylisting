<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use app\Models\Listing;

class ListingExpired extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ListingExp:Expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Listings status due the expired date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $listing = new Listing;
        $listing->title = 'title';
        $listing->save();
        $this->info('Success update Listings table!');
    }
}
