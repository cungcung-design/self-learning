<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\BookingReportExport;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportExportController extends Controller
{
    public function excel()
    {
        return Excel::download(new BookingReportExport, 'booking-report.xlsx');
    }

    public function pdf()
    {
        $bookings = Booking::with(['user', 'adventure'])->get();

        $pdf = Pdf::loadView('admin.reports.booking-pdf', [
            'bookings' => $bookings
        ]);

        return $pdf->download('booking-report.pdf');
    }
}
