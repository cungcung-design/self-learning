<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
    @include('admin.css')
</head>

<body>
    @include('admin.header')
    @include('admin.sidebar')

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <div class="row justify-content-center">
                    <div class="col-lg-8">

                        <!-- Form Card -->
                        <div class="border-0 shadow-sm card">
                            <div class="py-3 text-white card-header bg-dark">
                                <h5 class="mb-0 fw-bold">Edit Room: {{ $room->room_name }}</h5>
                            </div>

                            <div class="p-4 card-body">
                                <!-- Important: enctype is required for uploading images -->
                                <form action="{{ url('update_room', $room->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <!-- Room Name -->
                                        <div class="mb-3 col-md-6">
                                            <label class="font-weight-bold">Room Name</label>
                                            <input type="text" name="room_name" class="form-control"
                                                value="{{ $room->room_name }}" required>
                                        </div>

                                        <!-- Room Price -->
                                        <div class="mb-3 col-md-6">
                                            <label class="font-weight-bold">Room Price ($)</label>
                                            <input type="number" name="room_price" class="form-control"
                                                value="{{ $room->room_price }}" required>
                                        </div>

                                        <!-- Room Type -->
                                        <div class="mb-3 col-md-6">
                                            <label class="font-weight-bold">Room Type</label>
                                            <select name="room_type" class="form-control" required>
                                                <!-- Add your actual room types here -->
                                                <option value="Regular"
                                                    {{ $room->room_type == 'Regular' ? 'selected' : '' }}>Regular
                                                </option>
                                                <option value="Premium"
                                                    {{ $room->room_type == 'Premium' ? 'selected' : '' }}>Premium
                                                </option>
                                                <option value="Deluxe"
                                                    {{ $room->room_type == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
                                            </select>
                                        </div>

                                        <!-- Wi-Fi -->
                                        <div class="mb-3 col-md-6">
                                            <label class="font-weight-bold">Wi-Fi</label>
                                            <select name="room_wifi" class="form-control">
                                                <option value="yes"
                                                    {{ $room->room_wifi == 'yes' ? 'selected' : '' }}>Yes</option>
                                                <option value="no"
                                                    {{ $room->room_wifi == 'no' ? 'selected' : '' }}>
                                                    No</option>
                                            </select>
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-3 col-md-12">
                                            <label class="font-weight-bold">Room Description</label>
                                            <textarea name="room_description" class="form-control" rows="4" required>{{ $room->room_description }}</textarea>
                                        </div>

                                        <!-- Current Image Preview -->
                                        <div class="mb-4 col-md-6">
                                            <label class="font-weight-bold d-block">Current Image</label>
                                            <img src="{{ $room->room_image ? asset($room->room_image) : asset('admin/img/rooms/default.png') }}"
                                                class="rounded shadow-sm"
                                                style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #eee;"
                                                alt="Current Room Image">
                                        </div>

                                        <!-- Upload New Image -->
                                        <div class="mb-4 col-md-6">
                                            <label class="font-weight-bold">Update Image</label>
                                            <input type="file" name="room_image" class="form-control">
                                            <small class="text-muted">Leave blank if you don't want to change the
                                                current image.</small>
                                        </div>
                                    </div>

                                    <hr>

                                    <!-- Submit Button -->
                                    <div class="text-right">
                                        <a href="{{ url('view_room') }}" class="px-4 mr-2 btn btn-secondary">Cancel</a>
                                        <button type="submit" class="px-5 btn btn-success fw-bold">Update Room</button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('admin.footer')
</body>

</html>
