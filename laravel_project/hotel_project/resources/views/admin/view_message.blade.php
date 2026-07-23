<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Admin Panel</title>
    @include ('admin.css')
    
    <style>
        /* --- Modern Dashboard Styles --- */
        .page-content {
            padding: 2rem 1.5rem;
            min-height: 100vh;
            /* Removed hardcoded background color to use your default theme */
        }

        /* Sleek Card Container */
        .custom-card {
            /* Removed white background to let default theme show through */
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Page Header */
        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
            /* Text color will now inherit from your default theme */
        }

        /* Refined Table Styling */
        .table-custom {
            margin-bottom: 0;
            width: 100%;
        }
        
        .table-custom thead th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.8px;
            padding: 1.2rem 1.5rem;
            border-bottom: 2px solid rgba(0,0,0,0.05); /* Made border semi-transparent */
        }

        .table-custom tbody td {
            padding: 1.2rem 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        /* Soft hover effect using opacity so it works on any background color */
        .table-custom tbody tr:hover {
            background-color: rgba(0, 0, 0, 0.03); 
            transition: background-color 0.2s ease;
        }

        /* Prevent long messages from breaking the table layout */
        .msg-text {
            max-width: 350px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            font-weight: 500;
            opacity: 0.6;
        }
    </style>
</head>

<body>
    @include ('admin.header')
    @include ('admin.sidebar')

    <div class="page-content">
        <div class="container-fluid">
            
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="page-title">Customer Messages</h2>
            </div>

            <!-- Table Card -->
            <div class="shadow-sm custom-card">
                <div class="table-responsive">
                    <!-- Note: Added table-striped back in case your theme relies on it -->
                    <table class="table align-middle table-custom table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Message</th>
                                <th>Reply Email</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($message as $message)
                                <tr>
                                    <td style="font-weight: 500;">
                                        {{ $message->name }}
                                    </td>
                                    <td>
                                        <!-- Email link inherits standard link color -->
                                        <a href="mailto:{{ $message->email }}" style="text-decoration: none;">
                                            {{ $message->email }}
                                        </a>
                                    </td>
                                    <td>{{ $message->phone }}</td>
                                    <td class="message-text" title="{{ $message->message }}">
                                        {{ $message->message }}
                                    </td>
                                    <td>
                                      <a href=" {{route('reply_email', $message->id) }}" class="btn btn-success" >Reply Email</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        <div style="font-size: 1.1rem;">No messages available yet.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    @include('admin.footer')
</body>
</html>