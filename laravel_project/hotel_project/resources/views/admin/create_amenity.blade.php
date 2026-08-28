@extends('layouts.admin')

@section('title', 'Add Amenity | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="border-0 shadow-lg card">
                        <div class="text-white card-header bg-primary">
                            <h3 class="mb-0">
                                <i class="fa fa-check-square"></i> Add Amenity
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.amenities.store') }}" method="POST">
                                @csrf

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="name">Amenity Name</label>
                                    <input id="name" type="text" name="name" class="form-control"
                                        value="{{ old('name') }}" placeholder="Enter amenity name" required>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="slug">Slug</label>
                                    <input id="slug" type="text" name="slug" class="form-control"
                                        value="{{ old('slug') }}" placeholder="amenity-slug" required>
                                    <small class="text-muted">Used in URLs. Use lowercase letters, numbers, and hyphens only.</small>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="icon">Icon Class (Optional)</label>
                                    <input id="icon" type="text" name="icon" class="form-control"
                                        value="{{ old('icon') }}" placeholder="e.g. fa fa-wifi">
                                    <small class="text-muted">Font Awesome or Bootstrap icon class. Example: fa fa-wifi</small>
                                </div>

                                <hr>

                                <div class="text-right">
                                    <a href="{{ route('admin.amenities.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Add Amenity
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
