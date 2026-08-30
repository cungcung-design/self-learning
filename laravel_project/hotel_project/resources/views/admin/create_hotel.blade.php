@extends('layouts.admin')

@section('title', 'Add Hotel | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
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
                                            <label class="font-weight-bold" for="contact_info">Contact Information</label>
                                            <textarea id="contact_info" name="contact_info" rows="3" class="form-control"
                                                placeholder="Enter contact info">{{ old('contact_info') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4 form-group">
                                            <label class="font-weight-bold" for="rating">Rating (0 - 5)</label>
                                            <input id="rating" type="number" name="rating" class="form-control"
                                                value="{{ old('rating') }}" placeholder="Enter rating" min="0" max="5"
                                                step="0.1">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4 form-group">
                                            <label class="font-weight-bold" for="check_in_time">Check-in Time</label>
                                            <input id="check_in_time" type="text" name="check_in_time" class="form-control"
                                                value="{{ old('check_in_time') }}" placeholder="e.g. 14:00">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4 form-group">
                                            <label class="font-weight-bold" for="check_out_time">Check-out Time</label>
                                            <input id="check_out_time" type="text" name="check_out_time" class="form-control"
                                                value="{{ old('check_out_time') }}" placeholder="e.g. 12:00">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="image">Primary Hotel Image</label>
                                    <input id="image" type="file" name="image" class="form-control-file"
                                        accept="image/*">
                                    <small class="text-muted">This will be used as the main hotel image. You can also upload multiple images below.</small>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold">Hotel Images</label>
                                    <div class="hotel-images-upload-area"
                                        style="border: 2px dashed #ccc; padding: 30px; text-align: center; border-radius: 8px; cursor: pointer; background: #fafafa;">
                                        <i class="fa fa-cloud-upload" style="font-size: 40px; color: #007bff;"></i>
                                        <p style="margin-top: 10px; margin-bottom: 0;">Drag & drop images here or click to browse</p>
                                        <p class="text-muted" style="font-size: 12px;">You can upload up to 10 images. Click on an image to set it as primary.</p>
                                        <input type="file" name="hotel_images[]" multiple accept="image/*" id="hotel_images_input"
                                            style="display: none;">
                                    </div>
                                    <div id="hotel_image_previews" class="row mt-3"></div>
                                    <input type="hidden" name="primary_image_index" id="primary_image_index" value="0">
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const uploadArea = document.querySelector('.hotel-images-upload-area');
            const fileInput = document.getElementById('hotel_images_input');
            const previewsContainer = document.getElementById('hotel_image_previews');
            const primaryInput = document.getElementById('primary_image_index');
            let uploadedFiles = [];
            let primaryIndex = 0;

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

            function handleFiles(files) {
                const newFiles = Array.from(files);
                uploadedFiles = [...uploadedFiles, ...newFiles];
                if (uploadedFiles.length > 10) {
                    uploadedFiles = uploadedFiles.slice(0, 10);
                    if (window.showSiteToast) {
                        window.showSiteToast('warning', 'You can upload a maximum of 10 images.');
                    }
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
                            <div class="card ${index === primaryIndex ? 'border-primary' : ''}" style="cursor: pointer;" data-index="${index}">
                                <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Preview">
                                <div class="card-body p-2 text-center">
                                    <small class="text-muted">${file.name}</small>
                                    ${index === primaryIndex ? '<br><span class="badge badge-primary">Primary</span>' : ''}
                                </div>
                            </div>
                        `;
                        col.querySelector('.card').addEventListener('click', () => {
                            primaryIndex = index;
                            primaryInput.value = index;
                            renderPreviews();
                        });
                        previewsContainer.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>
@endsection
