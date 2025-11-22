<?php

namespace App\Providers;

use App\Events\DonationCompleted;
use App\Listeners\NotifyAdminOfDonation;
use App\Listeners\SendDonationConfirmationEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register donation event listeners
        Event::listen(
            DonationCompleted::class,
            [SendDonationConfirmationEmail::class, NotifyAdminOfDonation::class]
        );
    }
}
