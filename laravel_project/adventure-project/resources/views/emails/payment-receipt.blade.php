<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h1 style="color: #10b981;">🧾 Payment Receipt</h1>
    <p>Hello {{ $booking->user->name }},</p>
    <p>Your payment has been processed successfully. Here are your receipt details:</p>

    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">

    <h3 style="margin-bottom: 5px;">Transaction ID:</h3>
    <p style="margin-top: 0; font-weight: bold;">{{ $booking->payment->transaction_id ?? 'N/A' }}</p>

    <h3 style="margin-bottom: 5px;">Adventure:</h3>
    <p style="margin-top: 0; font-weight: bold;">{{ $booking->adventure->title }}</p>

    <h3 style="margin-bottom: 5px;">Payment Method:</h3>
    <p style="margin-top: 0;">{{ ucfirst($booking->payment->payment_method ?? 'N/A') }}</p>

    <h3 style="margin-bottom: 5px;">Amount Paid:</h3>
    <p style="margin-top: 0; font-weight: bold;">RM {{ $booking->payment->amount ?? $booking->total_price }}</p>

    <h3 style="margin-bottom: 5px;">Status:</h3>
    <p style="margin-top: 0; text-transform: uppercase; font-weight: bold;">{{ $booking->payment->status ?? 'Unpaid' }}</p>

    <p style="margin-top: 30px;">Thank you for choosing Adventure Explorer!</p>
</body>
</html>
