@extends('layouts.admin')

@section('title', 'Edit Amenity | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="border-0 shadow-sm card">
                        <div class="py-3 text-white card-header bg-dark">
                            <h5 class="mb-0 fw-bold">Edit Amenity: {{ $amenity->name }}</h5>
                        </div>
                        <div class="p-4 card-body">
                            <form action="{{ route('admin.amenities.update', $amenity) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="font-weight-bold" for="name">Amenity Name</label>
                                    <input id="name" type="text" name="name" class="form-control"
                                        value="{{ old('name', $amenity->name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="font-weight-bold" for="slug">Slug</label>
                                    <input id="slug" type="text" name="slug" class="form-control"
                                        value="{{ old('slug', $amenity->slug) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="font-weight-bold" for="icon">Icon Class (Optional)</label>
                                    <input id="icon" type="text" name="icon" class="form-control"
                                        value="{{ old('icon', $amenity->icon) }}" placeholder="e.g. fa fa-wifi">
                                </div>

                                <hr>

                                <div class="text-right">
                                    <a href="{{ route('admin.amenities.index') }}" class="px-4 mr-2 btn btn-secondary">Cancel</a>
                                    <button type="submit" class="px-5 btn btn-success fw-bold">Update Amenity</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
