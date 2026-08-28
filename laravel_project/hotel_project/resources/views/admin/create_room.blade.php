@extends('layouts.admin')

@section('title', 'Add Room | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="border-0 shadow-lg card">
                        <div class="text-white card-header bg-primary">
                            <h3 class="mb-0">
                                <i class="fa fa-bed"></i> Add New Room
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="room_name">Room Name</label>
                                    <input id="room_name" type="text" name="room_name" class="form-control"
                                        value="{{ old('room_name') }}" placeholder="Enter room name" required>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="room_description">Description</label>
                                    <textarea id="room_description" name="room_description" rows="5" class="form-control"
                                        placeholder="Enter room description">{{ old('room_description') }}</textarea>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold" for="room_price">Room Price</label>
                                    <input id="room_price" type="number" name="room_price" class="form-control"
                                        value="{{ old('room_price') }}" placeholder="Enter room price" min="0"
                                        step="0.01" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4 form-group">
                                            <label class="font-weight-bold" for="room_type">Room Type</label>
                                            <select id="room_type" name="room_type" class="form-control" required>
                                                @foreach (\App\Models\Room::TYPES as $type)
                                                    <option value="{{ $type }}" @selected(old('room_type') === $type)>
                                                        {{ ucfirst($type) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4 form-group">
                                            <label class="font-weight-bold" for="room_wifi">Wi-Fi</label>
                                            <select id="room_wifi" name="room_wifi" class="form-control" required>
                                                <option value="yes" @selected(old('room_wifi') === 'yes')>Yes</option>
                                                <option value="no" @selected(old('room_wifi', 'no') === 'no')>No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 form-group">
                                    <label class="font-weight-bold">Room Images</label>
                                    <div class="room-images-upload-area"
                                        style="border: 2px dashed #ccc; padding: 30px; text-align: center; border-radius: 8px; cursor: pointer; background: #fafafa;">
                                        <i class="fa fa-cloud-upload" style="font-size: 40px; color: #007bff;"></i>
                                        <p style="margin-top: 10px; margin-bottom: 0;">Drag & drop images here or click to browse</p>
                                        <p class="text-muted" style="font-size: 12px;">You can upload up to 10 images. Click on an image to set it as primary.</p>
                                        <input type="file" name="room_images[]" multiple accept="image/*" id="room_images_input"
                                            style="display: none;">
                                    </div>
                                    <div id="image_previews" class="row mt-3"></div>
                                    <input type="hidden" name="primary_image_index" id="primary_image_index" value="0">
                                </div>

                                <hr>

                                <div class="text-right">
                                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-plus"></i> Add Room
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
            const uploadArea = document.querySelector('.room-images-upload-area');
            const fileInput = document.getElementById('room_images_input');
            const previewsContainer = document.getElementById('image_previews');
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
