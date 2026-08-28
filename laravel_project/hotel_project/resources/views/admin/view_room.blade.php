@extends('layouts.admin')

@section('title', 'Rooms | Hotel Admin')

@section('styles')
    <style>
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        .room-mobile-card {
            display: none;
        }

        @media (max-width: 767.98px) {
            .room-desktop-table {
                display: none;
            }
            .room-mobile-card {
                display: block;
            }
        }

        @media (min-width: 768px) {
            .room-desktop-table {
                display: block;
            }
            .room-mobile-card {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="shadow-sm card">
                <div class="text-white card-header bg-dark d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">Rooms</h4>
                    <a href="{{ route('admin.rooms.create') }}" class="btn btn-sm btn-primary">+ Add Room</a>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.rooms.index') }}" class="form-inline mb-3">
                        <div class="row w-100">
                            <div class="col-md-4 mb-2">
                                <input type="text" name="q" class="form-control form-control-sm" placeholder="Search rooms..." value="{{ request('q') }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <select name="hotel_id" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">All Hotels</option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}" @selected(request('hotel_id') == $hotel->id)>
                                            {{ $hotel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <select name="room_type" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">All Types</option>
                                    @foreach (\App\Models\Room::TYPES as $type)
                                        <option value="{{ $type }}" @selected(request('room_type') === $type)>
                                            {{ ucfirst($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="1" @selected(request('status') === '1')>Available</option>
                                    <option value="0" @selected(request('status') === '0')>Unavailable</option>
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="room-desktop-table">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>IMG</th>
                                        <th>Room</th>
                                        <th>Hotel</th>
                                        <th>Guests</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($rooms as $room)
                                        <tr>
                                            <td>
                                                <img src="{{ $room->imageUrl() }}" class="rounded" width="70" height="50"
                                                    style="object-fit: cover;" alt="{{ $room->room_name }}">
                                            </td>
                                            <td>
                                                <strong>{{ $room->room_name }}</strong>
                                                <br><small class="text-muted">{{ ucfirst($room->room_type) }}</small>
                                            </td>
                                            <td>{{ $room->hotel->name ?? 'N/A' }}</td>
                                            <td>
                                                <i class="fa fa-user"></i> {{ $room->max_guests ?? 'N/A' }}
                                            </td>
                                            <td>${{ number_format((float) $room->room_price, 2) }} <small class="text-muted">/ night</small></td>
                                            <td>
                                                @if ($room->is_available)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-sm btn-info" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this room? This cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No rooms found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $rooms->links() }}
                        </div>
                    </div>

                    <div class="room-mobile-card">
                        @forelse ($rooms as $room)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $room->imageUrl() }}" class="rounded mr-3" width="60" height="60"
                                                style="object-fit: cover;" alt="{{ $room->room_name }}">
                                            <div>
                                                <h6 class="mb-0">{{ $room->room_name }}</h6>
                                                <small class="text-muted">{{ $room->hotel->name ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('admin.rooms.show', $room) }}" class="dropdown-item">View</a>
                                                <a href="{{ route('admin.rooms.edit', $room) }}" class="dropdown-item">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
                                                    onsubmit="return confirm('Delete this room? This cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3 text-muted small">
                                        <div class="col-6 mb-1">
                                            <i class="fa fa-user"></i> {{ $room->max_guests ?? 'N/A' }} Guests
                                        </div>
                                        <div class="col-6 mb-1">
                                            <i class="fa fa-bed"></i> {{ ucfirst($room->room_type) }}
                                        </div>
                                        <div class="col-6 mb-1">
                                            <i class="fa fa-bed"></i> {{ $room->bed_type ?? 'N/A' }}
                                        </div>
                                        <div class="col-6 mb-1">
                                            <strong class="text-primary">${{ number_format((float) $room->room_price, 2) }} / night</strong>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        @if ($room->is_available)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-sm btn-outline-info">View</a>
                                        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-outline-warning ml-1">Edit</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info mb-0">No rooms found.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
