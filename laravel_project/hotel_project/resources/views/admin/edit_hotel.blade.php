@extends('layouts.admin')

@section('title', 'Edit Hotel | Hotel Admin')

@section('styles')
    <style>
        .drag-over {
            outline: 2px dashed #007bff !important;
            outline-offset: -2px;
            background-color: #e9f2ff !important;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="border-0 shadow-sm card">
                        <div class="py-3 text-white card-header bg-dark">
                            <h5 class="mb-0 fw-bold">Edit Hotel: {{ $hotel->name }}</h5>
                        </div>
                        <div class="p-4 card-body">
                            <form id="edit-hotel-form" action="{{ route('admin.hotels.update', $hotel) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="{{ old('status', $hotel->status ?? 'active') }}">

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
                                        <label class="font-weight-bold" for="contact_info">Contact Information</label>
                                        <textarea id="contact_info" name="contact_info" class="form-control" rows="3">{{ old('contact_info', $hotel->contact_info) }}</textarea>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="rating">Rating (0 - 5)</label>
                                        <input id="rating" type="number" name="rating" class="form-control"
                                            value="{{ old('rating', $hotel->rating) }}" min="0" max="5" step="0.1">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="check_in_time">Check-in Time</label>
                                        <input id="check_in_time" type="text" name="check_in_time" class="form-control"
                                            value="{{ old('check_in_time', $hotel->check_in_time) }}" placeholder="e.g. 14:00">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="check_out_time">Check-out Time</label>
                                        <input id="check_out_time" type="text" name="check_out_time" class="form-control"
                                            value="{{ old('check_out_time', $hotel->check_out_time) }}" placeholder="e.g. 12:00">
                                    </div>
                                </div>

                                <div class="row">
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
                                </div>

         <div class="mb-4 form-group">
    <label class="font-weight-bold">Hotel Images</label>
    <div class="row" id="existing_hotel_images">
        @forelse ($hotel->hotelImages as $image)
            <div class="col-md-3 col-sm-4 mb-3" data-image-id="{{ $image->id }}" draggable="true">
                <div class="card h-100 {{ $image->is_primary ? 'border-primary' : '' }}">
                    <img src="{{ $image->imageUrl() }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Hotel image">
                    <div class="card-body p-2 px-3 d-flex align-items-center justify-content-between">
                        @if ($image->is_primary)
                            <span class="badge badge-primary py-2 px-3">Primary</span>
                        @else
                            <button type="submit" class="btn btn-sm btn-outline-primary" form="set-primary-hotel-image-{{ $image->id }}" onclick="return confirm('Set this image as primary?')">Set Primary</button>
                        @endif

                        <button type="submit" class="btn btn-sm btn-danger" form="delete-hotel-image-{{ $image->id }}" onclick="return confirm('Delete this image? This cannot be undone.')">Delete</button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted">No images uploaded yet.</p>
            </div>
        @endforelse
    </div>
</div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold">Add More Images</label>
                                    <div class="hotel-images-upload-area"
                                        style="border: 2px dashed #ccc; padding: 30px; text-align: center; border-radius: 8px; cursor: pointer; background: #fafafa;">
                                        <i class="fa fa-cloud-upload" style="font-size: 40px; color: #007bff;"></i>
                                        <p style="margin-top: 10px; margin-bottom: 0;">Drag & drop images here or click to browse</p>
                                        <p class="text-muted" style="font-size: 12px;">You can upload up to 10 additional images.</p>
                                        <input type="file" name="hotel_images[]" multiple accept="image/*" id="hotel_images_input"
                                            style="display: none;">
                                    </div>
                                    <div id="hotel_image_previews" class="row mt-3"></div>
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

                            @foreach ($hotel->hotelImages as $image)
                                @unless ($image->is_primary)
                                    <form id="set-primary-hotel-image-{{ $image->id }}" action="{{ route('admin.hotels.images.primary', $image) }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                @endunless
                                <form id="delete-hotel-image-{{ $image->id }}" action="{{ route('admin.hotels.images.destroy', $image) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const uploadArea = document.querySelector('.hotel-images-upload-area');
            const fileInput = document.getElementById('hotel_images_input');
            const previewsContainer = document.getElementById('hotel_image_previews');
            let uploadedFiles = [];

            if (uploadArea) {
                uploadArea.addEventListener('click', () => fileInput.click());

                uploadArea.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    uploadArea.style.borderColor = '#007bff';
                    uploadArea.style.background = '#e9f2ff';
                });

                uploadArea.addEventListener('dragleave', () => {
                    uploadArea.style.borderColor = '#ccc';
                    uploadArea.style.background = '#fafafa';
                });

                uploadArea.addEventListener('drop', (e) => {
                    e.preventDefault();
                    uploadArea.style.borderColor = '#ccc';
                    uploadArea.style.background = '#fafafa';
                    handleFiles(e.dataTransfer.files);
                });

                fileInput.addEventListener('change', () => {
                    handleFiles(fileInput.files);
                });
            }

            function handleFiles(files) {
                const newFiles = Array.from(files);
                uploadedFiles = [...uploadedFiles, ...newFiles];
                if (uploadedFiles.length > 10) {
                    uploadedFiles = uploadedFiles.slice(0, 10);
                    alert('You can upload a maximum of 10 images.');
                }
                renderPreviews();
                syncFileInput();
            }

            function syncFileInput() {
                const dataTransfer = new DataTransfer();
                uploadedFiles.forEach((file) => dataTransfer.items.add(file));
                fileInput.files = dataTransfer.files;
            }

            function renderPreviews() {
                previewsContainer.innerHTML = '';
                uploadedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 col-sm-4 mb-3';
                        col.innerHTML = `
                            <div class="card">
                                <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Preview">
                                <div class="card-body p-2 text-center">
                                    <small class="text-muted">${file.name}</small>
                                </div>
                            </div>
                        `;
                        previewsContainer.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                });
            }

            initHotelImageReorder();
        });

        function initHotelImageReorder() {
            const container = document.getElementById('existing_hotel_images');
            if (!container) return;

            let draggedItem = null;

            container.querySelectorAll('[data-image-id]').forEach(item => {
                item.setAttribute('draggable', 'true');

                item.addEventListener('dragstart', function (e) {
                    draggedItem = this;
                    this.style.opacity = '0.4';
                    e.dataTransfer.effectAllowed = 'move';
                });

                item.addEventListener('dragend', function () {
                    this.style.opacity = '1';
                    draggedItem = null;
                    container.querySelectorAll('[data-image-id]').forEach(el => {
                        el.classList.remove('drag-over');
                    });
                });

                item.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    this.classList.add('drag-over');
                });

                item.addEventListener('dragleave', function () {
                    this.classList.remove('drag-over');
                });

                item.addEventListener('drop', function (e) {
                    e.preventDefault();
                    this.classList.remove('drag-over');

                    if (!draggedItem || draggedItem === this) {
                        return;
                    }

                    const items = [...container.querySelectorAll('[data-image-id]')];
                    const draggedIndex = items.indexOf(draggedItem);
                    const targetIndex = items.indexOf(this);

                    if (draggedIndex < targetIndex) {
                        this.parentNode.insertBefore(draggedItem, this.nextSibling);
                    } else {
                        this.parentNode.insertBefore(draggedItem, this);
                    }

                    const order = [...container.querySelectorAll('[data-image-id]')].map(el => el.dataset.imageId);

                    fetch('{{ route('admin.hotels.images.reorder', $hotel) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ order }),
                    });
                });
            });
        }
    </script>
@endsection
