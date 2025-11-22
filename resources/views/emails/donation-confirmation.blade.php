<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Confirmation</title>
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
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
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
        .donation-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #b70003;
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
            font-weight: 700;
        }
        .amount {
            font-size: 24px;
            color: #b70003;
        }
        .message {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 14px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #b70003;
            text-decoration: none;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #b70003;
            color: white !important;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thank You for Your Donation!</h1>
        <p style="margin: 10px 0 0 0; opacity: 0.9;">Your generosity makes a difference</p>
    </div>

    <div class="content">
        <div class="message">
            <p>Dear {{ $donation->donor_name }},</p>
            <p>
                We are deeply grateful for your generous donation to Voices of Gaza.
                Your contribution helps us amplify the voices and stories from Gaza,
                ensuring that these important narratives reach people around the world.
            </p>
            <p>
                Every donation, regardless of size, makes a real impact in preserving
                and sharing these crucial stories. Thank you for standing with us.
            </p>
        </div>

        <div class="donation-details">
            <h3 style="margin-top: 0; color: #b70003;">Donation Details</h3>

            <div class="detail-row">
                <span class="detail-label">Amount:</span>
                <span class="detail-value amount">${{ number_format($donation->amount, 2) }} {{ $donation->currency }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Transaction ID:</span>
                <span class="detail-value">{{ $donation->transaction_id }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Payment Method:</span>
                <span class="detail-value">{{ ucfirst($donation->payment_method) }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Date:</span>
                <span class="detail-value">{{ $donation->paid_at->format('F d, Y h:i A') }}</span>
            </div>

            @if($donation->story_reference)
            <div class="detail-row">
                <span class="detail-label">Supporting Story:</span>
                <span class="detail-value">{{ $donation->story_reference }}</span>
            </div>
            @endif
        </div>

        <div style="text-align: center;">
            <p>This email serves as your receipt. Please keep it for your records.</p>
            <a href="{{ route('index') }}" class="button">Visit Our Website</a>
        </div>

        <div class="message">
            <h4 style="color: #b70003;">What Happens Next?</h4>
            <ul>
                <li>Your donation has been successfully processed</li>
                <li>Funds will be used to support our mission of sharing stories from Gaza</li>
                <li>You can view and share more stories on our website</li>
                <li>Feel free to make another donation or share our platform with others</li>
            </ul>
        </div>

        <div style="background: #fff3cd; padding: 15px; border-radius: 8px; border-left: 4px solid #ffc107;">
            <strong>Note:</strong> This donation supports our humanitarian efforts to document
            and share the experiences of people in Gaza. Your contribution is tax-deductible
            where applicable.
        </div>
    </div>

    <div class="footer">
        <p><strong>Voices of Gaza</strong></p>
        <p>Amplifying voices, preserving stories, sharing truth</p>

        <div class="social-links">
            <a href="#">Facebook</a> •
            <a href="#">Twitter</a> •
            <a href="#">Instagram</a>
        </div>

        <p style="font-size: 12px; color: #999; margin-top: 20px;">
            If you have any questions about your donation, please contact us.<br>
            This is an automated email, please do not reply directly.
        </p>
    </div>
</body>
</html>
