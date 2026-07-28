<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <h2>Your Adventure Booking is Confirmed!</h2>
    <p>Dear {{ $booking->user->name }},</p>
    <p>Your booking has been confirmed. Here are the details:</p>
    <table>
        <tr>
            <td><strong>Booking ID:</strong></td>
            <td>#{{ $booking->id }}</td>
        </tr>
        <tr>
            <td><strong>Adventure:</strong></td>
            <td>{{ $booking->adventure->title }}</td>
        </tr>
        <tr>
            <td><strong>Date:</strong></td>
            <td>{{ $booking->booking_date }}</td>
        </tr>
        <tr>
            <td><strong>Participants:</strong></td>
            <td>{{ $booking->participants }}</td>
        </tr>
        <tr>
            <td><strong>Status:</strong></td>
            <td>{{ ucfirst($booking->status) }}</td>
        </tr>
    </table>
    <p>Thank you for booking with AdventureBooking!</p>
</body>
</html>