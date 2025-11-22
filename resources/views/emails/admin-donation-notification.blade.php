<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Donation Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .alert {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .donation-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            color: #666;
            font-weight: 600;
        }
        .detail-value {
            color: #333;
        }
        .amount {
            font-size: 32px;
            color: #28a745;
            font-weight: 700;
            text-align: center;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #007bff;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎉 New Donation Received!</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">A supporter has made a donation</p>
    </div>

    <div class="content">
        <div class="alert">
            <strong>✓ Payment Confirmed</strong><br>
            A new donation has been successfully processed and added to the system.
        </div>

        <div class="amount">
            ${{ number_format($donation->amount, 2) }} {{ $donation->currency }}
        </div>

        <div class="donation-details">
            <h3 style="margin-top: 0; color: #007bff;">Donation Information</h3>

            <div class="detail-row">
                <span class="detail-label">Donation ID:</span>
                <span class="detail-value">#{{ $donation->id }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Donor Name:</span>
                <span class="detail-value">{{ $donation->donor_name }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Donor Email:</span>
                <span class="detail-value">{{ $donation->donor_email }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Amount:</span>
                <span class="detail-value">${{ number_format($donation->amount, 2) }} {{ $donation->currency }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Payment Method:</span>
                <span class="detail-value">{{ ucfirst($donation->payment_method) }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Transaction ID:</span>
                <span class="detail-value"><code>{{ $donation->transaction_id }}</code></span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Date & Time:</span>
                <span class="detail-value">{{ $donation->paid_at->format('F d, Y h:i A') }}</span>
            </div>

            @if($donation->story_reference)
            <div class="detail-row">
                <span class="detail-label">Story Reference:</span>
                <span class="detail-value">{{ $donation->story_reference }}</span>
            </div>
            @endif

            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    <strong style="color: #28a745;">{{ strtoupper($donation->status) }}</strong>
                </span>
            </div>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('dashboard.donations.show', $donation->id) }}" class="button">
                View in Dashboard
            </a>
        </div>

        <div style="background: #fff; padding: 15px; border-radius: 8px;">
            <h4 style="color: #007bff; margin-top: 0;">Quick Actions</h4>
            <ul>
                <li>View full donation details in the dashboard</li>
                <li>Download donation receipt</li>
                <li>Contact donor if needed</li>
                <li>Update donation records</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p><strong>Voices of Gaza - Admin Dashboard</strong></p>
        <p style="font-size: 12px; color: #999;">
            This is an automated notification from your donation management system.
        </p>
    </div>
</body>
</html>
