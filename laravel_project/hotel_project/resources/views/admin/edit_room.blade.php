@extends('layouts.admin')

@section('title', 'Edit Room | Hotel Admin')

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
                            <h5 class="mb-0 fw-bold">Edit Room: {{ $room->room_name }}</h5>
                        </div>
                        <div class="p-4 card-body">
                            <form action="{{ route('admin.rooms.update', $room) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="room_name">Room Name</label>
                                        <input id="room_name" type="text" name="room_name" class="form-control"
                                            value="{{ old('room_name', $room->room_name) }}" required>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="room_price">Room Price</label>
                                        <input id="room_price" type="number" name="room_price" class="form-control"
                                            value="{{ old('room_price', $room->room_price) }}" min="0" step="0.01"
                                            required>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="room_type">Room Type</label>
                                        <select id="room_type" name="room_type" class="form-control" required>
                                            @foreach (\App\Models\Room::TYPES as $type)
                                                <option value="{{ $type }}" @selected(old('room_type', $room->room_type) === $type)>
                                                    {{ ucfirst($type) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="font-weight-bold" for="room_wifi">Wi-Fi</label>
                                        <select id="room_wifi" name="room_wifi" class="form-control" required>
                                            <option value="yes" @selected(old('room_wifi', $room->room_wifi) === 'yes')>Yes</option>
                                            <option value="no" @selected(old('room_wifi', $room->room_wifi) === 'no')>No</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label class="font-weight-bold" for="room_description">Room Description</label>
                                        <textarea id="room_description" name="room_description" class="form-control" rows="4">{{ old('room_description', $room->room_description) }}</textarea>
                                    </div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold">Room Images</label>
                                    <div class="row" id="existing_images">
                                        @forelse ($room->roomImages as $image)
                                            <div class="col-md-3 col-sm-4 mb-3" data-image-id="{{ $image->id }}" draggable="true">
                                                <div class="card {{ $image->is_primary ? 'border-primary' : '' }}">
                                                    <img src="{{ asset($image->image_url) }}" class="card-img-top" style="height: 150px; object-fit: cover;" alt="Room image">
                                                    <div class="card-body p-2 text-center">
                                                        @if ($image->is_primary)
                                                            <span class="badge badge-primary">Primary</span>
                                                        @else
                                                            <form action="{{ route('admin.rooms.images.primary', $image) }}" method="POST" class="d-inline" onsubmit="return confirm('Set this image as primary?')">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-outline-primary">Set Primary</button>
                                                            </form>
                                                        @endif
                                                        <br>
                                                        <form action="{{ route('admin.rooms.images.destroy', $image) }}" method="POST" class="d-inline mt-1" onsubmit="return confirm('Delete this image? This cannot be undone.')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-muted">No images uploaded yet.</p>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold">Add More Images</label>
                                    <div class="room-images-upload-area"
                                        style="border: 2px dashed #ccc; padding: 30px; text-align: center; border-radius: 8px; cursor: pointer; background: #fafafa;">
                                        <i class="fa fa-cloud-upload" style="font-size: 40px; color: #007bff;"></i>
                                        <p style="margin-top: 10px; margin-bottom: 0;">Drag & drop images here or click to browse</p>
                                        <p class="text-muted" style="font-size: 12px;">You can upload up to 10 additional images.</p>
                                        <input type="file" name="room_images[]" multiple accept="image/*" id="room_images_input"
                                            style="display: none;">
                                    </div>
                                    <div id="image_previews" class="row mt-3"></div>
                                </div>

                                <hr>

                                <div class="text-right">
                                    <a href="{{ route('admin.rooms.index') }}" class="px-4 mr-2 btn btn-secondary">Cancel</a>
                                    <button type="submit" class="px-5 btn btn-success fw-bold">Update Room</button>
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
            const uploadArea = document.querySelector('.room-images-upload-area');
            const fileInput = document.getElementById('room_images_input');
            const previewsContainer = document.getElementById('image_previews');
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
                fileInput.value = '';
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

            initImageReorder();
        });

        function initImageReorder() {
            const container = document.getElementById('existing_images');
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

                    fetch('{{ route('admin.rooms.images.reorder', $room) }}', {
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
