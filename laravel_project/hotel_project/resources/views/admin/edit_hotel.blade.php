@extends('layouts.admin')

@section('title', 'Edit Hotel | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="border-0 shadow-sm card">
                        <div class="py-3 text-white card-header bg-dark">
                            <h5 class="mb-0 fw-bold">Edit Hotel: {{ $hotel->name }}</h5>
                        </div>
                        <div class="p-4 card-body">
                            <form action="{{ route('admin.hotels.update', $hotel) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="name">Hotel Name</label>
                                        <input id="name" type="text" name="name" class="form-control"
                                            value="{{ old('name', $hotel->name) }}" required>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="slug">Slug</label>
                                        <input id="slug" type="text" name="slug" class="form-control"
                                            value="{{ old('slug', $hotel->slug) }}" required>
                                    </div>
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label class="font-weight-bold" for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $hotel->description) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="price">Price per Night</label>
                                        <input id="price" type="number" name="price" class="form-control"
                                            value="{{ old('price', $hotel->price) }}" min="0" step="0.01" required>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="location">Location</label>
                                        <input id="location" type="text" name="location" class="form-control"
                                            value="{{ old('location', $hotel->location) }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="rating">Rating (0 - 5)</label>
                                        <input id="rating" type="number" name="rating" class="form-control"
                                            value="{{ old('rating', $hotel->rating) }}" min="0" max="5" step="0.1">
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="status">Status</label>
                                        <select id="status" name="status" class="form-control" required>
                                            <option value="active" @selected(old('status', $hotel->status) === 'active')>Active</option>
                                            <option value="inactive" @selected(old('status', $hotel->status) === 'inactive')>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="font-weight-bold d-block">Current Image</label>
                                    <img src="{{ $hotel->imageUrl() }}" class="rounded shadow-sm"
                                        style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #eee;"
                                        alt="Current hotel image">
                                </div>

                                <div class="mb-4 col-md-6">
                                    <label class="font-weight-bold" for="image">Update Image</label>
                                    <input id="image" type="file" name="image" class="form-control"
                                        accept="image/*">
                                    <small class="text-muted">Leave blank to keep the current image.</small>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold">Featured Categories</label>
                                    <div class="row">
                                        @foreach ($featuredCategories as $category)
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="featured_category_ids[]" value="{{ $category->id }}"
                                                        id="category_{{ $category->id }}"
                                                        {{ $hotel->featuredCategories->contains('id', $category->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold">Amenities</label>
                                    <div class="row">
                                        @foreach ($amenities as $amenity)
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="amenity_ids[]" value="{{ $amenity->id }}"
                                                        id="amenity_{{ $amenity->id }}"
                                                        {{ $hotel->amenities->contains('id', $amenity->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="amenity_{{ $amenity->id }}">
                                                        {{ $amenity->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <hr>

                                <div class="text-right">
                                    <a href="{{ route('admin.hotels.index') }}" class="px-4 mr-2 btn btn-secondary">Cancel</a>
                                    <button type="submit" class="px-5 btn btn-success fw-bold">Update Hotel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
