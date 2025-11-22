<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationManagementController extends Controller
{
    /**
     * Display a listing of donations
     */
    public function index(Request $request)
    {
        $query = Donation::query()->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by donor name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('donor_name', 'like', "%{$search}%")
                  ->orWhere('donor_email', 'like', "%{$search}%")
                  ->orWhere('transaction_id', 'like', "%{$search}%");
            });
        }

        $donations = $query->paginate(20);

        // Calculate statistics
        $stats = [
            'total_donations' => Donation::count(),
            'total_amount' => Donation::where('status', 'completed')->sum('amount'),
            'completed_count' => Donation::where('status', 'completed')->count(),
            'pending_count' => Donation::where('status', 'pending')->count(),
            'failed_count' => Donation::where('status', 'failed')->count(),
            'paypal_count' => Donation::where('payment_method', 'paypal')->where('status', 'completed')->count(),
            'paypal_amount' => Donation::where('payment_method', 'paypal')->where('status', 'completed')->sum('amount'),
        ];

        return view('dashboard.donations.index', compact('donations', 'stats'));
    }

    /**
     * Display the specified donation
     */
    public function show(Donation $donation)
    {
        return view('dashboard.donations.show', compact('donation'));
    }

    /**
     * Export donations to CSV
     */
    public function export(Request $request)
    {
        $query = Donation::query()->orderBy('created_at', 'desc');

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $donations = $query->get();

        $filename = 'donations_' . now()->format('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($donations) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'ID',
                'Donor Name',
                'Donor Email',
                'Amount',
                'Currency',
                'Payment Method',
                'Status',
                'Transaction ID',
                'Story Reference',
                'Paid At',
                'Created At'
            ]);

            // Add data rows
            foreach ($donations as $donation) {
                fputcsv($file, [
                    $donation->id,
                    $donation->donor_name,
                    $donation->donor_email,
                    $donation->amount,
                    $donation->currency,
                    $donation->payment_method,
                    $donation->status,
                    $donation->transaction_id,
                    $donation->story_reference,
                    $donation->paid_at?->format('Y-m-d H:i:s'),
                    $donation->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
