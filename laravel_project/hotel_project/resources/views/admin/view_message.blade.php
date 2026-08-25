@extends('layouts.admin')

@section('title', 'Messages | Hotel Admin')

@section('styles')
    <style>
        .msg-text {
            max-width: 350px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            font-weight: 500;
            opacity: 0.6;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
            <h2 class="h4">Customer Messages</h2>
            <form method="GET" action="{{ route('admin.messages.index') }}" class="form-inline">
                <input type="text" name="q" class="form-control form-control-sm mr-2" placeholder="Search messages"
                    value="{{ request('q') }}">
                <select name="status" class="form-control form-control-sm mr-2">
                    <option value="">All</option>
                    <option value="open" @selected(request('status') === 'open')>Unreplied</option>
                </select>
                <button class="btn btn-sm btn-primary" type="submit">Search</button>
            </form>
        </div>

        <div class="block">
            <div class="table-responsive">
                <table class="table align-middle table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Reply</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($messages as $contact)
                            <tr>
                                <td>{{ $contact->name }}</td>
                                <td>
                                    <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                                </td>
                                <td>{{ $contact->phone }}</td>
                                <td class="msg-text" title="{{ $contact->message }}">
                                    {{ $contact->message }}
                                </td>
                                <td>
                                    @if ($contact->isReplied())
                                        <span class="badge badge-success">Replied</span>
                                    @else
                                        <span class="badge badge-warning">New</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.messages.reply', $contact) }}" class="btn btn-success btn-sm">
                                        Reply Email
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">No messages available yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $messages->links() }}
            </div>
        </div>
    </div>
@endsection
