<?php

namespace App\Listeners;

use App\Events\DonationCompleted;
use App\Mail\AdminDonationNotificationMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotifyAdminOfDonation implements ShouldQueue
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
            // Get all admin users
            $admins = User::where('is_admin', true)->get();

            foreach ($admins as $admin) {
                Mail::to($admin->email)
                    ->send(new AdminDonationNotificationMail($event->donation));
            }

            Log::info('Admin notification emails sent for donation', [
                'donation_id' => $event->donation->id,
                'admins_notified' => $admins->count(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send admin notification emails', [
                'donation_id' => $event->donation->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
