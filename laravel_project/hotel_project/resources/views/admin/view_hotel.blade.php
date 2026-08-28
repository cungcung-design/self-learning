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

        .hotel-mobile-card {
            display: none;
        }

        @media (max-width: 767.98px) {
            .hotel-desktop-table {
                display: none;
            }
            .hotel-mobile-card {
                display: block;
            }
        }

        @media (min-width: 768px) {
            .hotel-desktop-table {
                display: block;
            }
            .hotel-mobile-card {
                display: none;
            }
        }

        .badge-category {
            font-size: 11px;
            margin-right: 4px;
            margin-bottom: 4px;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="shadow-sm card">
                <div class="text-white card-header bg-dark d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">Hotels</h4>
                    <a href="{{ route('admin.hotels.create') }}" class="btn btn-sm btn-primary">+ Add Hotel</a>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.hotels.index') }}" class="form-inline mb-3">
                        <div class="row w-100">
                            <div class="col-md-4 mb-2">
                                <input type="text" name="q" class="form-control form-control-sm" placeholder="Search hotels..." value="{{ request('q') }}">
                            </div>
                            <div class="col-md-3 mb-2">
                                <select name="location" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">All Locations</option>
                                    @php
                                        $locations = \App\Models\Hotel::query()
                                            ->select('location')
                                            ->distinct()
                                            ->orderBy('location')
                                            ->pluck('location');
                                    @endphp
                                    @foreach ($locations as $loc)
                                        <option value="{{ $loc }}" @selected(request('location') === $loc)>
                                            {{ $loc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-2">
                                <select name="category" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach (\App\Models\FeaturedCategory::query()->orderBy('name')->get() as $category)
                                        <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-2">
                                <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="active" @selected(request('status') === 'active')>Active</option>
                                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="hotel-desktop-table">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>IMG</th>
                                        <th>Hotel</th>
                                        <th>Location</th>
                                        <th>Rating</th>
                                        <th>Rooms</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($hotels as $hotel)
                                        <tr>
                                            <td>
                                                <img src="{{ $hotel->imageUrl() }}" class="rounded" width="70" height="50"
                                                    style="object-fit: cover;" alt="{{ $hotel->name }}">
                                            </td>
                                            <td>
                                                <strong>{{ $hotel->name }}</strong>
                                                <br>
                                                @foreach ($hotel->featuredCategories as $category)
                                                    @if ($category->slug === 'luxury')
                                                        <span class="badge badge-info badge-category">💎 {{ $category->name }}</span>
                                                    @elseif ($category->slug === 'popular')
                                                        <span class="badge badge-warning badge-category">🔥 {{ $category->name }}</span>
                                                    @elseif ($category->slug === 'best-seller')
                                                        <span class="badge badge-success badge-category">🏆 {{ $category->name }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ $hotel->location ?? 'N/A' }}</td>
                                            <td>
                                                @if ($hotel->rating)
                                                    <span class="badge badge-warning">
                                                        <i class="fa fa-star"></i> {{ number_format((float) $hotel->rating, 1) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <i class="fa fa-bed"></i> {{ $hotel->rooms->count() }}
                                            </td>
                                            <td>
                                                @if ($hotel->status === 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.hotels.show', $hotel) }}" class="btn btn-sm btn-info" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.hotels.edit', $hotel) }}" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST" class="d-inline"
                                                    onsubmit="return confirm('Delete this hotel? This cannot be undone.')">
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
                                            <td colspan="7" class="text-center">No hotels found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $hotels->links() }}
                        </div>
                    </div>

                    <div class="hotel-mobile-card">
                        @forelse ($hotels as $hotel)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $hotel->imageUrl() }}" class="rounded mr-3" width="60" height="60"
                                                style="object-fit: cover;" alt="{{ $hotel->name }}">
                                            <div>
                                                <h6 class="mb-0">{{ $hotel->name }}</h6>
                                                <small class="text-muted">{{ $hotel->location ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-toggle="dropdown">
                                                <i class="fa fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="{{ route('admin.hotels.show', $hotel) }}" class="dropdown-item">View</a>
                                                <a href="{{ route('admin.hotels.edit', $hotel) }}" class="dropdown-item">Edit</a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('admin.hotels.destroy', $hotel) }}" method="POST"
                                                    onsubmit="return confirm('Delete this hotel? This cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        @foreach ($hotel->featuredCategories as $category)
                                            @if ($category->slug === 'luxury')
                                                <span class="badge badge-info badge-category">💎 {{ $category->name }}</span>
                                            @elseif ($category->slug === 'popular')
                                                <span class="badge badge-warning badge-category">🔥 {{ $category->name }}</span>
                                            @elseif ($category->slug === 'best-seller')
                                                <span class="badge badge-success badge-category">🏆 {{ $category->name }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="row mt-3 text-muted small">
                                        <div class="col-6 mb-1">
                                            @if ($hotel->rating)
                                                <i class="fa fa-star"></i> {{ number_format((float) $hotel->rating, 1) }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                        <div class="col-6 mb-1">
                                            <i class="fa fa-bed"></i> {{ $hotel->rooms->count() }} Rooms
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        @if ($hotel->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('admin.hotels.show', $hotel) }}" class="btn btn-sm btn-outline-info">View</a>
                                        <a href="{{ route('admin.hotels.edit', $hotel) }}" class="btn btn-sm btn-outline-warning ml-1">Edit</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info mb-0">No hotels found.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
