@extends('layouts.admin')

@section('title', 'View Room | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Rooms
                    </a>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit Room
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        @php
                            $mainImage = $room->primaryImage?->image_url ?? $room->room_image;
                        @endphp
                        <img src="{{ \App\Support\PublicImage::url($mainImage) }}"
                             class="card-img h-100" style="object-fit: cover; min-height: 380px;"
                             alt="{{ $room->room_name }}">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h2 class="card-title mb-1">{{ $room->room_name }}</h2>
                            <p class="text-muted mb-3">
                                @if ($room->hotel)
                                    <i class="fa fa-building"></i> {{ $room->hotel->name }}
                                @else
                                    No hotel assigned
                                @endif
                            </p>
                            <div class="mb-3">
                                @if ($room->hotel?->rating)
                                    <span class="badge badge-warning mr-2">
                                        <i class="fa fa-star"></i> {{ number_format((float) $room->hotel->rating, 1) }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-primary mb-3">
                                ${{ number_format((float) $room->room_price, 2) }} <small class="text-muted">/ night</small>
                            </h3>
                            <div class="row text-muted small">
                                <div class="col-md-6 mb-2">
                                    <i class="fa fa-bed"></i> {{ $room->bed_type ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <i class="fa fa-user"></i> {{ $room->max_guests ?? 'N/A' }} Guests
                                </div>
                                <div class="col-md-6 mb-2">
                                    <i class="fa fa-expand"></i> {{ $room->room_size ?? 'N/A' }}
                                </div>
                                <div class="col-md-6 mb-2">
                                    <i class="fa fa-wifi"></i> {{ $room->hasWifi() ? 'Wi-Fi Available' : 'No Wi-Fi' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Room Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Room Type:</strong> {{ ucfirst($room->room_type) }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Bed Type:</strong> {{ $room->bed_type ?? 'N/A' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Maximum Guests:</strong> {{ $room->max_guests ?? 'N/A' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Room Size:</strong> {{ $room->room_size ?? 'N/A' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Availability:</strong>
                            @if ($room->is_available)
                                <span class="badge bg-success">Available</span>
                            @else
                                <span class="badge bg-danger">Unavailable</span>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3">
                        <strong>Description:</strong>
                        <p class="mb-0">{{ $room->room_description ?? 'No description provided.' }}</p>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Room Images</h5>
                    <span class="badge badge-light">{{ $room->roomImages->count() }} Images</span>
                </div>
                <div class="card-body">
                    @if ($room->roomImages->isNotEmpty())
                        <div class="row">
                            @foreach ($room->roomImages as $image)
                                <div class="col-md-2 col-sm-4 mb-3">
                                    <img src="{{ $image->imageUrl() }}" class="img-fluid rounded"
                                         style="height: 120px; object-fit: cover; width: 100%;"
                                         alt="{{ $room->room_name }} — {{ $image->featureLabel() }}">
                                    <small class="d-block text-muted mt-1">{{ $image->featureLabel() }}</small>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No room images uploaded yet.</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Room Amenities</h5>
                </div>
                <div class="card-body">
                    @if ($room->roomAmenities->isNotEmpty())
                        <div class="row">
                            @foreach ($room->roomAmenities as $amenity)
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <i class="{{ $amenity->icon ?? 'fa fa-check' }}"></i> {{ $amenity->name }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No amenities assigned to this room.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
