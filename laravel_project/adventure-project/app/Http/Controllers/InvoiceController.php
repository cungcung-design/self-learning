<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        $booking->load(['user', 'adventure', 'payment']);

        $pdf = Pdf::loadView('invoice.booking', [
            'booking' => $booking,
        ]);

        return $pdf->download("invoice-{$booking->id}.pdf");
    }
}
