<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; color: #333; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; font-size: 16px; }
        .heading { background: #f7f7f7; font-weight: bold; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <h2>AdventureBooking Invoice</h2>
        <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
        <p><strong>Customer:</strong> {{ $booking->user->name }}</p>
        <p><strong>Adventure:</strong> {{ $booking->adventure->title }}</p>
        <p><strong>Date:</strong> {{ $booking->booking_date }}</p>
        <hr>
        <h3>Total Amount: RM {{ $booking->participants * $booking->adventure->price }}</h3>
    </div>
</body>
</html>