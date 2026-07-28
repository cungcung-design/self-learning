<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Report</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; color: #333; }
        h1 { color: #2563eb; margin-bottom: 0; }
        p { color: #64748b; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; font-size: 13px; }
        th { background-color: #f8fafc; color: #475569; }
    </style>
</head>
<body>
    <h1>Adventure Explorer</h1>
    <p>Official System Booking Report</p>

    <table>
        <tr>
            <th>Customer</th>
            <th>Adventure</th>
            <th>Date</th>
            <th>Status</th>
            <th>Amount</th>
        </tr>
        @foreach($bookings as $booking)
        <tr>
            <td>{{ $booking->user->name }}</td>
            <td>{{ $booking->adventure->title }}</td>
            <td>{{ $booking->booking_date }}</td>
            <td>{{ ucfirst($booking->status) }}</td>
            <td>RM {{ $booking->total_price }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>
