<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/public">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Message | Admin Panel</title>
    @include ('admin.css')

    <style>
        /* --- Compact & Transparent Form Styles --- */
        .page-content {
            padding: 1.5rem 1rem;
            min-height: 100vh;
        }

        /* Narrower container for a more compact look */
        .mail-form-container {
            max-width: 550px;
            margin: 0 auto;
        }

        /* Removed white background, using subtle border/shadow */
        .custom-card {
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
            overflow: hidden;
        }

        /* Removed colored background, adapting to theme */
        .card-header-custom {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            letter-spacing: 0.5px;
        }

        /* Reduced padding for smaller footprint */
        .card-body-custom {
            padding: 1.5rem;
        }

        /* Form Inputs */
        .custom-label {
            font-weight: 600;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.8;
        }

        /* Made inputs transparent and smaller */
        .custom-input {
            border-radius: 6px;
            border: 1px solid rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0.75rem;
            font-size: 0.95rem;
            width: 100%;
            transition: all 0.2s ease;
            background-color: transparent;
            color: inherit;
        }

        .custom-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            background-color: transparent;
        }

        /* Tighter spacing between fields */
        .form-group-spacing {
            margin-bottom: 1rem;
        }

        /* Button styling with margin-top fix */
        .btn-send {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            border: none;
            width: 100%;
            font-size: 1rem;
            transition: all 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 30px;
        }

        .btn-send:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }
    </style>
</head>

<body>
    @include ('admin.header')
    @include ('admin.sidebar')

    <div class="page-content">
        <div class="container-fluid">

            <div class="mail-form-container">
                <div class="custom-card">

                    <!-- Header -->
                    <div class="card-header-custom">
                        <h1 class="page-title">
                            <i class="fas fa-paper-plane" style="color: #3b82f6; margin-right: 6px;"></i>
                            Send Mail to {{ $message->name }}
                        </h1>
                    </div>

                    <!-- Form Body -->
                    <div class="card-body-custom">
                        <form action="{{ url('send_email', $message->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <!-- Greeting -->
                            <div class="form-group-spacing">
                                <label class="custom-label">Greeting Line</label>
                                <input type="text" name="greeting" autocomplete="off" class="custom-input"
                                    placeholder="{{ $message->name }}," required>
                            </div>

                            <!-- Mail Body -->
                            <div class="form-group-spacing">
                                <label class="custom-label">Mail Body</label>
                                <textarea name="body" autocomplete="off" rows="5" class="custom-input" placeholder="" required></textarea>
                            </div>

                            <!-- Action Text -->
                            <div class="form-group-spacing">
                                <label class="custom-label">Action Text</label>
                                <input type="text" name="action_text" autocomplete="off" class="custom-input"
                                    placeholder="" autocomplete="off">
                            </div>

                            <!-- Action URL -->
                            <div class="form-group-spacing">
                                <label class="custom-label">Action URL</label>
                                <input type="url" name="action_url" autocomplete="off" class="custom-input"
                                    placeholder="">
                            </div>

                            <!-- End Line -->
                            <div class="form-group-spacing">
                                <label class="custom-label">Closing Line</label>
                                <input type="text" name="end_line" class="custom-input" placeholder="">
                            </div>

                            <!-- Submit Button (Wrapper div removed as requested) -->
                            <button type="submit" class="btn-send">
                                <i class="fas fa-reply"></i> Send Reply
                            </button>

                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

    @include('admin.footer')
</body>

</html>
