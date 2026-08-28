@extends('layouts.admin')

@section('title', 'Amenities | Hotel Admin')

@section('styles')
    <style>
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }

        .table-hover tbody tr:hover {
            background-color: #f5f5f5;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="shadow-sm card">
                <div class="text-white card-header bg-dark d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="mb-0">Amenities</h4>
                    <div>
                        <form method="GET" action="{{ route('admin.amenities.index') }}" class="form-inline d-inline-block mr-2">
                            <input type="text" name="q" class="form-control form-control-sm" placeholder="Search amenities"
                                value="{{ request('q') }}">
                            <button class="btn btn-sm btn-light" type="submit">Search</button>
                        </form>
                        <a href="{{ route('admin.amenities.create') }}" class="btn btn-sm btn-primary">Add Amenity</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-striped table-hover table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Icon</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($amenities as $index => $amenity)
                                    <tr>
                                        <td>{{ $amenities->firstItem() + $index }}</td>
                                        <td>{{ $amenity->name }}</td>
                                        <td>{{ $amenity->slug }}</td>
                                        <td>
                                            @if ($amenity->icon)
                                                <i class="{{ $amenity->icon }}"></i> {{ $amenity->icon }}
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.amenities.edit', $amenity) }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('admin.amenities.destroy', $amenity) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Delete this amenity? This cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No amenities found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $amenities->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
