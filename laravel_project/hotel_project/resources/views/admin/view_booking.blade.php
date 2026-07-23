<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include ('admin.css')

    <!-- Modern Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            /* Deep slate background */
            color: #e2e8f0;
            /* Off-white/light gray text for readability */
        }

        /* Dark Mode Card Container */
        .table-container {
            background: #1e293b;
            /* Slightly lighter slate for depth */
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            /* Deeper shadow for dark mode */
            padding: 24px;
            margin-top: 20px;
            overflow-x: auto;
            border: 1px solid #334155;
            /* Subtle border definition */
        }

        /* Table Formatting */
        .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            color: #cbd5e1;
            /* Muted text for general table data */
        }

        .table thead th {
            background-color: #0f172a;
            /* Inset header background */
            color: #94a3b8;
            /* Dimmed header text */
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 16px;
            border-bottom: 1px solid #334155;
            border-top: none;
        }

        /* Rounding the top corners of the header */
        .table thead tr th:first-child {
            border-top-left-radius: 8px;
        }

        .table thead tr th:last-child {
            border-top-right-radius: 8px;
        }

        .table tbody td {
            padding: 16px;
            vertical-align: middle;
            font-size: 0.9rem;
            border-bottom: 1px solid #334155;
        }

        .table-hover tbody tr:hover {
            background-color: #334155;
            /* Highlight row on hover */
            transition: background-color 0.2s ease;
        }

        /* Glowing Status Badge */
        /* Glowing Status Badge - Base Shape */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            text-align: center;
        }

        /* Green for Approved */
        .status-approved {
            background-color: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border: 1px solid rgba(52, 211, 153, 0.3);
        }

        /* Red for Rejected */
        .status-rejected {
            background-color: rgba(225, 29, 72, 0.15);
            color: #fb7185;
            border: 1px solid rgba(225, 29, 72, 0.3);
        }

        /* Yellow/Amber for Pending/Waiting */
        .status-pending {
            background-color: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        /* Emphasis for specific data */
        .text-highlight {
            color: #f8fafc;
            font-weight: 500;
        }

        /* Image Thumbnail Styling */
        .room-thumbnail {
            width: 80px;
            height: 60px;
            object-fit: cover;
            /* Prevents image distortion */
            border-radius: 8px;
            border: 1px solid #334155;
        }

        /* Fallback text for missing images */
        .text-muted-dark {
            color: #64748b;
            font-size: 0.85rem;
            font-style: italic;
        }

        /* Preserving your original custom classes */
        td .wifi,
        td .room_type {
            color: #e2e8f0;
            font-weight: bold;
            padding: 8px 0px !important;
            border-radius: 5px;
            display: inline-block;
            text-align: center;
        }

        td .wifi {
            width: 110px;
        }

        td .room_type {
            width: 80px;
        }

        /* Button Containers */
        .action-buttons,
        .status-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* Base Button Styling */
        .btn-action,
        .btn-status {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 1px solid transparent;
        }

        /* Delete Button (Rose/Red) */
        .btn-delete {
            background-color: rgba(225, 29, 72, 0.15);
            color: #fb7185;
            border-color: rgba(225, 29, 72, 0.3);
        }

        .btn-delete:hover {
            background-color: rgba(225, 29, 72, 0.25);
            color: #f43f5e;
        }

        /* Approve Button (Emerald/Green) */
        .btn-approve {
            background-color: rgba(16, 185, 129, 0.15);
            color: #34d399;
            border-color: rgba(16, 185, 129, 0.3);
        }

        .btn-approve:hover {
            background-color: rgba(16, 185, 129, 0.25);
            color: #10b981;
        }

        /* Reject Button (Amber/Orange) */
        .btn-reject {
            background-color: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
            border-color: rgba(245, 158, 11, 0.3);
        }

        .btn-reject:hover {
            background-color: rgba(245, 158, 11, 0.25);
            color: #f59e0b;
        }

        a:hover {
            text-decoration: none;
        }

        .btn-email {
            background-color: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            border-color: rgba(59, 130, 246, 0.3);
        }

        .btn-email:hover {
            background-color: rgba(59, 130, 246, 0.25);
            color: #3b82f6;
        }
    </style>
</head>

<body>
    @include ('admin.header')
    @include ('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">

                <div class="table-container">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Room ID</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                                <th>Room Name</th>
                                <th>Room Price</th>
                                <th>Room Image</th>
                                <th>Actions</th>
                                <th>Status Update</th>
                                <th>Email Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td class="text-highlight">#{{ $booking->room_id }}</td>
                                    <td class="text-highlight">{{ $booking->name }}</td>
                                    <td>{{ $booking->email }}</td>
                                    <td>{{ $booking->phone }}</td>
                                    <td>{{ $booking->start_date }}</td>
                                    <td>{{ $booking->end_date }}</td>
                                    <td>
                                        @if (strtolower($booking->status) == 'approved')
                                            <span class="status-badge status-approved">{{ $booking->status }}</span>
                                        @elseif(strtolower($booking->status) == 'rejected')
                                            <span class="status-badge status-rejected">{{ $booking->status }}</span>
                                        @else
                                            <span class="status-badge status-pending">{{ $booking->status }}</span>
                                        @endif
                                    </td>
                                    <td class="text-highlight">{{ optional($booking->room)->room_name ?? 'N/A' }}</td>
                                    <td class="text-highlight">{{ optional($booking->room)->room_price ?? 'N/A' }}</td>
                                    <td>
                                        @if (optional($booking->room)->room_image)
                                            <img src="{{ asset(optional($booking->room)->room_image) }}"
                                                alt="Room Image" class="room-thumbnail">
                                        @else
                                            <span class="text-muted-dark">No Image</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('delete_booking', $booking->id) }}"
                                            class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                    <td>
                                        <div class="status-buttons">
                                            <a href="{{ url('approve_booking', $booking->id) }}"
                                                class="btn-status btn-approve">Approve</a>
                                            <a href="{{ url('reject_booking', $booking->id) }}"
                                                class="btn-status btn-reject">Reject</a>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="{{ url('send_email', $booking->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-status btn-email">
                                                Send Email
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    @include('admin.footer')
</body>

</html>
