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

        td .wifi {
            color: #fff;
            font-weight: bold;
            padding: 8px 0px !important;
            border-radius: 5px;
            display: inline-block;
            width: 110px;
        }

        td .room_type {
            color: #fff;
            font-weight: bold;
            padding: 8px 0px !important;
            border-radius: 5px;
            display: inline-block;
            width: 80px;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="shadow-sm card">
                <div class="text-white card-header bg-dark d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">Room List</h4>
                    <div>
                        <form method="GET" action="{{ route('admin.rooms.index') }}" class="form-inline d-inline-block mr-2">
                            <input type="text" name="q" class="form-control form-control-sm" placeholder="Search rooms"
                                value="{{ request('q') }}">
                            <button class="btn btn-sm btn-light" type="submit">Search</button>
                        </form>
                        <a href="{{ route('admin.rooms.create') }}" class="btn btn-sm btn-primary">Add Room</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Room Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Wifi</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rooms as $index => $room)
                                    <tr>
                                        <td>{{ $rooms->firstItem() + $index }}</td>
                                        <td>{{ $room->room_name }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($room->room_description, 50) }}</td>
                                        <td>${{ number_format((float) $room->room_price, 2) }}</td>
                                        <td>
                                            <span class="badge bg-primary room_type">
                                                {{ ucfirst($room->room_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if ($room->hasWifi())
                                                <span class="badge bg-success wifi">
                                                    <i class="fa fa-wifi"></i> Available
                                                </span>
                                            @else
                                                <span class="badge bg-danger wifi">
                                                    <i class="fa fa-times"></i> Not Available
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <img src="{{ $room->imageUrl() }}" class="rounded" width="80" height="50"
                                                style="object-fit: cover;" alt="{{ $room->room_name }}">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.rooms.edit', $room) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Delete this room? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No rooms found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $rooms->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
