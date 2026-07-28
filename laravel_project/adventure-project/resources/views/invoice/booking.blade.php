<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.6; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); }
        h1 { font-size: 24px; color: #2563eb; margin-bottom: 20px; }
        h3 { font-size: 16px; margin-top: 20px; margin-bottom: 8px; color: #475569; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        th { background-color: #f8fafc; }
        .total { margin-top: 20px; font-size: 18px; font-weight: bold; color: #2563eb; }
        .status { text-transform: uppercase; font-weight: bold; }
        .footer { margin-top: 40px; text-align: center; font-size: 12px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h1>Adventure Explorer Invoice</h1>

        <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
        <p><strong>Invoice Date:</strong> {{ $booking->created_at->format('d M Y') }}</p>

        <hr style="border: 0; border-top: 1px solid #cbd5e1;">

        <h3>Customer Information</h3>
        <p><strong>Name:</strong> {{ $booking->user->name }}</p>
        <p><strong>Email:</strong> {{ $booking->user->email }}</p>

        <h3>Adventure Details</h3>
        <table>
            <tr>
                <th>Adventure</th>
                <th>Date</th>
                <th>Participants</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td>{{ $booking->adventure->title }}</td>
                <td>{{ $booking->booking_date }}</td>
                <td>{{ $booking->participants }}</td>
                <td>RM {{ $booking->total_price }}</td>
            </tr>
        </table>

        <div class="total">
            Total Paid: RM {{ $booking->total_price }}
        </div>

        <p style="margin-top: 20px;">
            <strong>Payment Status:</strong>
            <span class="status">{{ $booking->payment->status ?? 'Paid' }}</span>
        </p>

        <p class="footer">
            Thank you for booking with Adventure Explorer! This is a system-generated document.
        </p>
    </div>
</body>
</html>
