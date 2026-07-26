<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmed</title>
</head>
<body>

<h2>Hello {{ $booking->user->name }},</h2>

<p>Your booking has been confirmed successfully.</p>

<hr>

<p><strong>Adventure:</strong> {{ $booking->adventure->title }}</p>

<p><strong>Date:</strong> {{ $booking->booking_date }}</p>

<p><strong>Participants:</strong> {{ $booking->participants }}</p>

<p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>

<hr>

<p>Thank you for choosing Adventure Explorer!</p>

</body>
</html>