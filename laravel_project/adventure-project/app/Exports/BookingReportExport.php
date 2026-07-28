<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Booking::with(['user', 'adventure'])->get();
    }

    public function headings(): array
    {
        return ['ID', 'Customer', 'Adventure', 'Date', 'Status', 'Amount'];
    }

    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->user->name,
            $booking->adventure->title,
            $booking->booking_date,
            $booking->status,
            $booking->total_price,
        ];
    }
}
