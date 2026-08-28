@extends('layouts.admin')

@section('title', 'Add Hotel | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="border-0 shadow-lg card">
                        <div class="text-white card-header bg-primary">
                            <h3 class="mb-0">
                                <i class="fa fa-building"></i> Add New Hotel
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="name">Hotel Name</label>
                                    <input id="name" type="text" name="name" class="form-control"
                                        value="{{ old('name') }}" placeholder="Enter hotel name" required>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="slug">Slug</label>
                                    <input id="slug" type="text" name="slug" class="form-control"
                                        value="{{ old('slug') }}" placeholder="hotel-slug" required>
                                    <small class="text-muted">Used in URLs. Use lowercase letters, numbers, and hyphens only.</small>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="description">Description</label>
                                    <textarea id="description" name="description" rows="5" class="form-control"
                                        placeholder="Enter hotel description">{{ old('description') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4 form-group">
                                            <label class="font-weight-bold" for="price">Price per Night</label>
                                            <input id="price" type="number" name="price" class="form-control"
                                                value="{{ old('price') }}" placeholder="Enter price" min="0"
                                                step="0.01" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4 form-group">
                                            <label class="font-weight-bold" for="location">Location</label>
                                            <input id="location" type="text" name="location" class="form-control"
                                                value="{{ old('location') }}" placeholder="Enter location">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4 form-group">
                                            <label class="font-weight-bold" for="rating">Rating (0 - 5)</label>
                                            <input id="rating" type="number" name="rating" class="form-control"
                                                value="{{ old('rating') }}" placeholder="Enter rating" min="0" max="5"
                                                step="0.1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4 form-group">
                                            <label class="font-weight-bold" for="status">Status</label>
                                            <select id="status" name="status" class="form-control" required>
                                                <option value="active" @selected(old('status') === 'active')>Active</option>
                                                <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="image">Hotel Image</label>
                                    <input id="image" type="file" name="image" class="form-control-file"
                                        accept="image/*">
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
                                                        {{ in_array($category->id, old('featured_category_ids', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if ($featuredCategories->isEmpty())
                                        <p class="text-muted">No featured categories available. Please create one first.</p>
                                    @endif
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
                                                        {{ in_array($amenity->id, old('amenity_ids', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="amenity_{{ $amenity->id }}">
                                                        {{ $amenity->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if ($amenities->isEmpty())
                                        <p class="text-muted">No amenities available. Please create one first.</p>
                                    @endif
                                </div>

                                <hr>

                                <div class="text-right">
                                    <a href="{{ route('admin.hotels.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Add Hotel
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
