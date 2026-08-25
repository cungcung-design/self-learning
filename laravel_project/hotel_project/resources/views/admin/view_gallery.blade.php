@extends('layouts.admin')

@section('title', 'Gallery | Hotel Admin')

@section('styles')
    <style>
        .upload-container {
            background: #1e293b;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #334155;
            margin-bottom: 30px;
        }

        .upload-form {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .gallery-card {
            background: #1e293b;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #334155;
            display: flex;
            flex-direction: column;
        }

        .gallery-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-actions {
            padding: 15px;
            display: flex;
            justify-content: center;
        }

        .btn-delete {
            background-color: rgba(225, 29, 72, 0.15);
            color: #fb7185;
            border: 1px solid rgba(225, 29, 72, 0.3);
            padding: 8px 16px;
            border-radius: 6px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <h2 class="mb-4 text-white">Gallery Management</h2>

            <div class="upload-container">
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data"
                    class="upload-form">
                    @csrf
                    <label class="form-label text-white" for="image">Add New Image:</label>
                    <input id="image" type="file" name="image" class="form-control" accept="image/*" required>
                    <button type="submit" class="btn btn-primary">Upload Image</button>
                </form>
            </div>

            <div class="gallery-grid">
                @forelse ($galleries as $gallery)
                    <div class="gallery-card">
                        <img src="{{ $gallery->imageUrl() }}" alt="Gallery image" class="gallery-img">
                        <div class="card-actions">
                            <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST"
                                onsubmit="return confirm('Delete this image?')" style="width: 100%;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Delete Image</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-white">No gallery images yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
