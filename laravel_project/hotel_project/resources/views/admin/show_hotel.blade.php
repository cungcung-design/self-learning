@extends('layouts.admin')

@section('title', 'View Hotel | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-md-6">
                    <a href="{{ route('admin.hotels.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Hotels
                    </a>
                </div>
                <div class="col-md-6 text-right">
                    <a href="{{ route('admin.hotels.edit', $hotel) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit Hotel
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="row no-gutters">
                    <div class="col-md-5">
                        @php
                            $mainImage = $hotel->primaryImage?->image_url ?? $hotel->image;
                        @endphp
                        <img src="{{ \App\Support\PublicImage::url($mainImage, 'images/gallery1.jpg') }}"
                             class="card-img h-100" style="object-fit: cover; min-height: 380px;"
                             alt="{{ $hotel->name }}">
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h2 class="card-title mb-2">{{ $hotel->name }}</h2>
                            <div class="mb-3">
                                @if ($hotel->rating)
                                    <span class="badge badge-warning mr-2">
                                        <i class="fa fa-star"></i> {{ number_format((float) $hotel->rating, 1) }}
                                    </span>
                                @endif
                                <span class="text-muted">
                                    <i class="fa fa-map-marker"></i> {{ $hotel->location ?? 'N/A' }}
                                </span>
                            </div>
                            <div class="mb-3">
                                @forelse ($hotel->featuredCategories as $category)
                                    <span class="badge badge-info mr-1 mb-1">
                                        @if ($category->slug === 'luxury')
                                            💎
                                        @elseif ($category->slug === 'popular')
                                            🔥
                                        @elseif ($category->slug === 'best-seller')
                                            🏆
                                        @endif
                                        {{ $category->name }}
                                    </span>
                                @empty
                                    <span class="text-muted">No featured categories</span>
                                @endforelse
                            </div>
                            <div class="row text-muted small">
                                <div class="col-md-6 mb-1">
                                    <i class="fa fa-camera"></i> {{ $hotel->hotelImages->count() }} Images
                                </div>
                                <div class="col-md-6 mb-1">
                                    <i class="fa fa-bed"></i> {{ $hotel->rooms->count() }} Rooms
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Hotel Information</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">{{ $hotel->description ?? 'No description provided.' }}</p>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <strong>Check-in:</strong> {{ $hotel->check_in_time ?? 'N/A' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Check-out:</strong> {{ $hotel->check_out_time ?? 'N/A' }}
                        </div>
                        <div class="col-md-12 mt-2">
                            <strong>Contact:</strong> {{ $hotel->contact_info ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Hotel Images</h5>
                    <span class="badge badge-light">{{ $hotel->hotelImages->count() }} Images</span>
                </div>
                <div class="card-body">
                    @if ($hotel->hotelImages->isNotEmpty())
                        <div class="row">
                            @foreach ($hotel->hotelImages->take(6) as $image)
                                <div class="col-md-2 col-sm-4 mb-3">
                                    <img src="{{ $image->imageUrl() }}" class="img-fluid rounded"
                                         style="height: 120px; object-fit: cover; width: 100%;"
                                         alt="Hotel image">
                                </div>
                            @endforeach
                            @if ($hotel->hotelImages->count() > 6)
                                <div class="col-md-2 col-sm-4 mb-3 d-flex align-items-center justify-content-center">
                                    <a href="{{ route('admin.hotels.edit', $hotel) }}" class="btn btn-outline-primary">
                                        +{{ $hotel->hotelImages->count() - 6 }} More
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-muted mb-0">No hotel images uploaded yet.</p>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Hotel Amenities</h5>
                </div>
                <div class="card-body">
                    @if ($hotel->amenities->isNotEmpty())
                        <div class="row">
                            @foreach ($hotel->amenities as $amenity)
                                <div class="col-md-4 col-sm-6 mb-2">
                                    <i class="{{ $amenity->icon ?? 'fa fa-check' }}"></i> {{ $amenity->name }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No amenities assigned to this hotel.</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Rooms</h5>
                    <span class="badge badge-light">{{ $hotel->rooms->count() }} Rooms</span>
                </div>
                <div class="card-body">
                    @if ($hotel->rooms->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table align-middle table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Image</th>
                                        <th>Room Name</th>
                                        <th>Type</th>
                                        <th>Price</th>
                                        <th>Availability</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hotel->rooms as $room)
                                        <tr>
                                            <td>
                                                <img src="{{ $room->imageUrl() }}" class="rounded"
                                                     width="70" height="50" style="object-fit: cover;"
                                                     alt="{{ $room->room_name }}">
                                            </td>
                                            <td>{{ $room->room_name }}</td>
                                            <td>
                                                <span class="badge bg-primary">{{ ucfirst($room->room_type) }}</span>
                                            </td>
                                            <td>${{ number_format((float) $room->room_price, 2) }}</td>
                                            <td>
                                                @if ($room->is_available)
                                                    <span class="badge bg-success">Available</span>
                                                @else
                                                    <span class="badge bg-danger">Unavailable</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">No rooms assigned to this hotel yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
