@extends('layouts.admin')

@section('title', 'Reply to Message | Hotel Admin')

@section('styles')
    <style>
        .mail-form-container {
            max-width: 550px;
            margin: 0 auto;
        }

        .custom-card {
            border-radius: 10px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header-custom {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .card-body-custom {
            padding: 1.5rem;
        }

        .custom-label {
            font-weight: 600;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .custom-input {
            border-radius: 6px;
            border: 1px solid rgba(0, 0, 0, 0.15);
            padding: 0.5rem 0.75rem;
            width: 100%;
            background-color: transparent;
            color: inherit;
        }

        .form-group-spacing {
            margin-bottom: 1rem;
        }

        .btn-send {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            border: none;
            width: 100%;
            margin-top: 30px;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="mail-form-container">
            <div class="custom-card">
                <div class="card-header-custom">
                    <h1 class="h4 mb-0">Send Mail to {{ $contact->name }}</h1>
                </div>
                <div class="card-body-custom">
                    <form action="{{ route('admin.messages.send', $contact) }}" method="POST">
                        @csrf

                        <div class="form-group-spacing">
                            <label class="custom-label" for="greeting">Greeting Line</label>
                            <input id="greeting" type="text" name="greeting" class="custom-input"
                                value="{{ old('greeting', 'Hello '.$contact->name.',') }}" required>
                        </div>

                        <div class="form-group-spacing">
                            <label class="custom-label" for="body">Mail Body</label>
                            <textarea id="body" name="body" rows="5" class="custom-input" required>{{ old('body') }}</textarea>
                        </div>

                        <div class="form-group-spacing">
                            <label class="custom-label" for="action_text">Action Text</label>
                            <input id="action_text" type="text" name="action_text" class="custom-input"
                                value="{{ old('action_text') }}">
                        </div>

                        <div class="form-group-spacing">
                            <label class="custom-label" for="action_url">Action URL</label>
                            <input id="action_url" type="url" name="action_url" class="custom-input"
                                value="{{ old('action_url') }}">
                        </div>

                        <div class="form-group-spacing">
                            <label class="custom-label" for="end_line">Closing Line</label>
                            <input id="end_line" type="text" name="end_line" class="custom-input"
                                value="{{ old('end_line', 'Thank you for contacting us.') }}">
                        </div>

                        <button type="submit" class="btn-send">Send Reply</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
