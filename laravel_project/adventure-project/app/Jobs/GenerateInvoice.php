<?php

namespace App\Jobs;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateInvoice implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function handle()
    {
        $this->booking->load(['user', 'adventure', 'payment']);

        $pdf = Pdf::loadView('invoice.booking', [
            'booking' => $this->booking,
        ]);

        $filePath = 'invoices/invoice-' . $this->booking->id . '.pdf';

        Storage::disk('public')->put($filePath, $pdf->output());
    }
}
