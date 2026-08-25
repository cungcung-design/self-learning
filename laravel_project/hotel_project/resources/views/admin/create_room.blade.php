@extends('layouts.admin')

@section('title', 'Add Room | Hotel Admin')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
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
                                    <label class="font-weight-bold" for="room_image">Room Image</label>
                                    <input id="room_image" type="file" name="room_image" class="form-control-file"
                                        accept="image/*">
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
