@extends('layouts.admin')

@section('title', 'Dashboard | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">Dashboard</h2>
        </div>
    </div>

    <section class="no-padding-top no-padding-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon"><i class="icon-home"></i></div>
                                <strong>Rooms</strong>
                            </div>
                            <div class="number dashtext-1">{{ $roomCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon"><i class="icon-padnote"></i></div>
                                <strong>Bookings</strong>
                            </div>
                            <div class="number dashtext-2">{{ $bookingCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon"><i class="icon-clock"></i></div>
                                <strong>Pending</strong>
                            </div>
                            <div class="number dashtext-3">{{ $pendingBookingCount }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon"><i class="icon-mail"></i></div>
                                <strong>Messages</strong>
                            </div>
                            <div class="number dashtext-4">{{ $messageCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="statistic-block block">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <strong>Approved check-ins today</strong>
                            </div>
                            <div class="number dashtext-1">{{ $checkInsToday }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="statistic-block block">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <strong>Approved stay value</strong>
                            </div>
                            <div class="number dashtext-2">${{ number_format($estimatedRevenue, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="no-padding-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7">
                    <div class="block">
                        <div class="title"><strong>Recent Bookings</strong></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Guest</th>
                                        <th>Room</th>
                                        <th>Dates</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentBookings as $booking)
                                        <tr>
                                            <td>{{ $booking->name }}</td>
                                            <td>{{ $booking->room?->room_name ?? 'N/A' }}</td>
                                            <td>
                                                {{ $booking->start_date?->format('M d') }}
                                                -
                                                {{ $booking->end_date?->format('M d') }}
                                            </td>
                                            <td>{{ ucfirst($booking->status) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No bookings yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary">View all bookings</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="block">
                        <div class="title"><strong>Recent Messages</strong></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Message</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentMessages as $contact)
                                        <tr>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($contact->message, 40) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">No messages yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-primary">View all messages</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
