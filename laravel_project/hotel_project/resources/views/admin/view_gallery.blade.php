<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('admin.css')

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #e2e8f0;
        }

        .upload-container {
            background: #1e293b;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #334155;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .upload-form {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .form-label {
            font-weight: 500;
            color: #cbd5e1;
            margin-bottom: 0;
        }

        .file-input {
            background-color: #0f172a;
            color: #cbd5e1;
            border: 1px solid #334155;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .btn-upload {
            background-color: #3b82f6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-upload:hover {
            background-color: #2563eb;
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
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            display: flex;
            flex-direction: column;
        }

        .gallery-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
        }

        .gallery-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #334155;
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
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            width: 100%;
            text-align: center;
        }

        .btn-delete:hover {
            background-color: rgba(225, 29, 72, 0.25);
            color: #f43f5e;
            text-decoration: none;
        }
    </style>
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <h2 class="mb-4 text-white">Gallery Management</h2>

                <div class="upload-container">
                    <form action="{{ url('upload_gallery') }}" method="POST" enctype="multipart/form-data"
                        class="upload-form">
                        @csrf
                        <label class="form-label">Add New Image:</label>
                        <input type="file" name="image" class="file-input" required>
                        <button type="submit" class="btn-upload">Upload Image</button>
                    </form>
                </div>

                <div class="gallery-grid">
                    @forelse($galleries as $gallery)
                        <div class="gallery-card">
                            <img src="/admin/img/gallery/{{ $gallery->image }}" alt="Gallery Image" class="gallery-img">
                            <div class="card-actions">
                                <a href="{{ url('delete_gallery', $gallery->id) }}" class="btn-delete"
                                    onclick="return confirm('Delete this image?')">Delete Image</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-white">No gallery images yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @include('admin.footer')
</body>

</html>
