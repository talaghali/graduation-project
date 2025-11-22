<?php

namespace App\Listeners;

use App\Events\DonationCompleted;
use App\Mail\DonationConfirmationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendDonationConfirmationEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DonationCompleted $event): void
    {
        try {
            Mail::to($event->donation->donor_email)
                ->send(new DonationConfirmationMail($event->donation));

            Log::info('Donation confirmation email sent', [
                'donation_id' => $event->donation->id,
                'donor_email' => $event->donation->donor_email,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send donation confirmation email', [
                'donation_id' => $event->donation->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
