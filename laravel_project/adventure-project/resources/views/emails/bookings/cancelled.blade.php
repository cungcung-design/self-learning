<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h1 style="color: #ef4444;">❌ Booking Cancelled</h1>
    <p>Hello {{ $booking->user->name }},</p>
    <p>Your adventure booking has been cancelled. Here are the details:</p>
    
    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
    
    <h3 style="margin-bottom: 5px;">Adventure:</h3>
    <p style="margin-top: 0; font-weight: bold;">{{ $booking->adventure->title }}</p>
    
    <h3 style="margin-bottom: 5px;">Booking Date:</h3>
    <p style="margin-top: 0;">{{ $booking->booking_date }}</p>
    
    <h3 style="margin-bottom: 5px;">Participants:</h3>
    <p style="margin-top: 0;">{{ $booking->participants }}</p>
    
    <p style="margin-top: 30px;">If this was a mistake, please contact support or rebook your adventure.</p>
</body>
</html>
