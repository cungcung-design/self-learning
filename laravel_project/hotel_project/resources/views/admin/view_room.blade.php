<!DOCTYPE html>
<html lang="en">


<head>
    @include('admin.css')
</head>
<style>
    .shadow-sm {
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
    }

    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }

    td .wifi {
        color: #fff;
        font-weight: bold;
        padding: 8px 0px !important;
        border-radius: 5px;
        display: inline-block;
        width: 110px;
    }

    td .room_type {
        color: #fff;
        font-weight: bold;
        padding: 8px 0px !important;
        border-radius: 5px;
        display: inline-block;
        width: 80px;
    }
</style>

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
                <div class="shadow-sm card">
                    <div class="text-white card-header bg-dark">
                        <h4 class="mb-0">
                            Room List
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-striped table-hover table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Room Name</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Type</th>
                                        <th>Wifi</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>

                                    @forelse ($rooms as $index => $room)
                                        <tr>

                                            <td>
                                                {{ $index + 1 }}
                                            </td>
                                            <td>
                                                {{ $room->room_name }}
                                            </td>
                                            <td>
                                                {{ Str::limit($room->room_description, 50) }}
                                            </td>
                                            <td>
                                                $
                                                {{ number_format($room->room_price, 2) }}
                                            </td>

                                            <td>
                                                <span class="badge bg-primary room_type">
                                                    {{ $room->room_type }}
                                                </span>
                                            </td>


                                            <td>


                                                @if (strtolower((string) $room->room_wifi) === 'yes')
                                                    <span class="badge bg-success wifi">
                                                        <i class="fa fa-wifi"></i> Available
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger wifi">
                                                        <i class="fa fa-times"></i> Not Available
                                                    </span>
                                                @endif
                                            </td>

                                            <td>
                                                <img src="{{ $room->room_image ? asset($room->room_image) : asset('admin/img/rooms/default.png') }}"
                                                    class="rounded" width="80" height="50"
                                                    style="object-fit: cover;" alt="Room Image"
                                                    onerror="this.onerror=null;this.src='{{ asset('admin/img/rooms/default.png') }}';">
                                            </td>
                                            <td>
                                                <a href="{{ route('edit_room', $room->id) }}"
                                                    class="btn btn-sm btn-warning">
                                                    Edit
                                                </a>
                                                <a href="{{ route('delete_room', $room->id) }}"
                                                    class="btn btn-sm btn-danger">
                                                    Delete
                                                </a>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                No rooms found.
                                            </td>

                                        </tr>
                                    @endforelse


                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


            </div>
        </div>

    </div>


    @include('admin.footer')

</body>

</html>
