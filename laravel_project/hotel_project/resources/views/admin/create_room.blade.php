<!DOCTYPE html>
<html>

<head>
    @include ('admin.css')

</head>

<body>
    @include ('admin.header')

    @include ('admin.sidebar')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="page-content">
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

                                <form action="{{ route('add_room') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Room Name -->
                                    <div class="mb-4 form-group">
                                        <label class="font-weight-bold">Room Name</label>
                                        <input type="text" name="room_name" class="form-control"
                                            placeholder="Enter room name">
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-4 form-group">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea name="room_description" rows="5" class="form-control" placeholder="Enter room description"></textarea>
                                    </div>
                                    <!-- Room Price -->
                                    <div class="mb-4 form-group">
                                        <label class="font-weight-bold">Room Price (RM)</label>
                                        <input type="number" name="room_price" class="form-control"
                                            placeholder="Enter room price" min="0" step="0.01">
                                    </div>

                                    <div class="row">

                                        <!-- Room Type -->
                                        <div class="col-md-6">
                                            <div class="mb-4 form-group">
                                                <label class="font-weight-bold">Room Type</label>
                                                <select name="room_type" class="form-control">
                                                    <option value="regular">Regular</option>
                                                    <option value="premium">Premium</option>
                                                    <option value="suite">Suite</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Wifi -->
                                        <div class="col-md-6">
                                            <div class="mb-4 form-group">
                                                <label class="font-weight-bold">Wi-Fi</label>
                                                <select name="room_wifi" class="form-control">
                                                    <option value="yes">Yes</option>
                                                    <!-- Added "selected" here -->
                                                    <option value="no" selected>No</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Image -->
                                    <div class="mb-4 form-group">
                                        <label class="font-weight-bold">Room Image</label>
                                        <input type="file" name="room_image" class="form-control-file">
                                    </div>

                                    <hr>

                                    <!-- Buttons -->
                                    <div class="text-right">
                                        <button type="reset" class="btn btn-secondary">
                                            Reset
                                        </button>

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
    </div>
    @include('admin.footer')
</body>

</html>
