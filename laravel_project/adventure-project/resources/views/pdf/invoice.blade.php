<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; line-height: 1.5; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); }
        .header { font-size: 24px; font-weight: bold; color: #2563eb; margin-bottom: 20px; }
        .details { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details th, .details td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        .details th { background-color: #f8fafc; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">Adventure Explorer Invoice</div>
        <p><strong>Invoice No:</strong> INV-{{ $booking->payment->id ?? 'PENDING' }}</p>
        <p><strong>Date:</strong> {{ $booking->created_at->format('d M Y') }}</p>

        <table class="details">
            <tr>
                <th>Customer Details</th>
                <td>{{ $booking->user->name }} ({{ $booking->user->email }})</td>
            </tr>
            <tr>
                <th>Adventure Package</th>
                <td>{{ $booking->adventure->title }}</td>
            </tr>
            <tr>
                <th>Participants</th>
                <td>{{ $booking->participants }} Persons</td>
            </tr>
            <tr>
                <th>Payment Status</th>
                <td style="text-transform: uppercase; font-weight: bold;">{{ $booking->payment->status ?? 'Unpaid' }}</td>
            </tr>
            <tr>
                <th>Total Amount</th>
                <td><strong>RM {{ $booking->total_price }}</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>
