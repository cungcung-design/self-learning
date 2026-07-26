<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Booking Alert</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">

<h2>Hello Admin,</h2>

<p>A new adventure booking has just been submitted and requires your attention.</p>

<hr style="border: 0; border-top: 1px solid #eee;">

<p><strong>Customer Name:</strong> {{ $booking->user->name }}</p>
<p><strong>Customer Email:</strong> {{ $booking->user->email }}</p>
<p><strong>Adventure:</strong> {{ $booking->adventure->title }}</p>
<p><strong>Booking Date:</strong> {{ $booking->booking_date }}</p>
<p><strong>Participants:</strong> {{ $booking->participants }}</p>
<p><strong>Total Value:</strong> RM {{ $booking->participants * $booking->adventure->price }}</p>

<hr style="border: 0; border-top: 1px solid #eee;">

<p>You can log in to your admin dashboard to manage this booking.</p>

</body>
</html>