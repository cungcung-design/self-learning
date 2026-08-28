@extends('layouts.admin')

@section('title', 'Hotels | Hotel Admin')

@section('styles')
    <style>
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }

        td .status {
            color: #fff;
            font-weight: bold;
            padding: 8px 12px !important;
            border-radius: 5px;
            display: inline-block;
            min-width: 90px;
            text-align: center;
        }

        td .rating {
            color: #fff;
            font-weight: bold;
            padding: 8px 12px !important;
            border-radius: 5px;
            display: inline-block;
            min-width: 60px;
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="shadow-sm card">
                <div class="text-white card-header bg-dark d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">Hotel List</h4>
                    <div>
                        <form method="GET" action="{{ route('admin.hotels.index') }}" class="form-inline d-inline-block mr-2">
                            <input type="text" name="q" class="form-control form-control-sm" placeholder="Search hotels"
                                value="{{ request('q') }}">
                            <button class="btn btn-sm btn-light" type="submit">Search</button>
                        </form>
                        <a href="{{ route('admin.hotels.create') }}" class="btn btn-sm btn-primary">Add Hotel</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Price</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hotels as $index => $hotel)
                                    <tr>
                                        <td>{{ $hotels->firstItem() + $index }}</td>
                                        <td>{{ $hotel->name }}</td>
                                        <td>{{ $hotel->location ?? 'N/A' }}</td>
                                        <td>${{ number_format((float) $hotel->price, 2) }}</td>
                                        <td>
                                            @if ($hotel->rating)
                                                <span class="badge bg-warning rating">
                                                    <i class="fa fa-star"></i> {{ number_format((float) $hotel->rating, 1) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary rating">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($hotel->status === 'active')
                                                <span class="badge bg-success status">Active</span>
                                            @else
                                                <span class="badge bg-danger status">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <img src="{{ $hotel->imageUrl() }}" class="rounded" width="80" height="50"
                                                style="object-fit: cover;" alt="{{ $hotel->name }}">
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.hotels.edit', $hotel) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Delete this hotel? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No hotels found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $hotels->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
