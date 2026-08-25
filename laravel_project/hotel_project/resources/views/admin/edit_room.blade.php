@extends('layouts.admin')

@section('title', 'Edit Room | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
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

                                    <div class="mb-4 col-md-6">
                                        <label class="font-weight-bold d-block">Current Image</label>
                                        <img src="{{ $room->imageUrl() }}" class="rounded shadow-sm"
                                            style="width: 150px; height: 150px; object-fit: cover; border: 2px solid #eee;"
                                            alt="Current room image">
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label class="font-weight-bold" for="room_image">Update Image</label>
                                        <input id="room_image" type="file" name="room_image" class="form-control"
                                            accept="image/*">
                                        <small class="text-muted">Leave blank to keep the current image.</small>
                                    </div>
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
