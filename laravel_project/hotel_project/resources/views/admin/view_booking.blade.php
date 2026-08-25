@extends('layouts.admin')

@section('title', 'Bookings | Hotel Admin')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            text-align: center;
        }

        .status-approved {
            background-color: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(52, 211, 153, 0.3);
        }

        .status-rejected {
            background-color: rgba(225, 29, 72, 0.15);
            color: #fb7185;
            border: 1px solid rgba(225, 29, 72, 0.3);
        }

        .status-cancelled {
            background-color: rgba(148, 163, 184, 0.2);
            color: #cbd5e1;
            border: 1px solid rgba(148, 163, 184, 0.3);
        }

        .room-thumbnail {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .status-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="block">
                <div class="title d-flex justify-content-between align-items-center flex-wrap">
                    <strong>Bookings</strong>
                    <form method="GET" action="{{ route('admin.bookings.index') }}" class="form-inline">
                        <input type="text" name="q" class="form-control form-control-sm mr-2" placeholder="Search guest"
                            value="{{ request('q') }}">
                        <select name="status" class="form-control form-control-sm mr-2">
                            <option value="">All statuses</option>
                            @foreach (['pending', 'approved', 'rejected', 'cancelled'] as $status)
                                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary" type="submit">Filter</button>
                    </form>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Nights</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Room</th>
                                <th>Nightly</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->name }}</td>
                                    <td>{{ $booking->email }}</td>
                                    <td>{{ $booking->phone }}</td>
                                    <td>{{ $booking->start_date?->toFormattedDateString() }}</td>
                                    <td>{{ $booking->end_date?->toFormattedDateString() }}</td>
                                    <td>{{ $booking->nights() }}</td>
                                    <td>${{ number_format($booking->totalAmount(), 2) }}</td>
                                    <td>
                                        @if ($booking->isApproved())
                                            <span class="status-badge status-approved">Approved</span>
                                        @elseif ($booking->isRejected())
                                            <span class="status-badge status-rejected">Rejected</span>
                                        @elseif ($booking->isCancelled())
                                            <span class="status-badge status-cancelled">Cancelled</span>
                                        @else
                                            <span class="status-badge status-pending">Pending</span>
                                        @endif
                                    </td>
                                    <td>{{ $booking->room?->room_name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($booking->room)
                                            ${{ number_format((float) $booking->room->room_price, 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($booking->room)
                                            <img src="{{ $booking->room->imageUrl() }}" alt="Room image"
                                                class="room-thumbnail">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="status-buttons">
                                            @if ($booking->isPending())
                                                <form action="{{ route('admin.bookings.approve', $booking) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.bookings.reject', $booking) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning btn-sm">Reject</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('admin.bookings.email', $booking) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-info btn-sm">Send Email</button>
                                            </form>
                                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
                                                onsubmit="return confirm('Delete this booking?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No bookings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
