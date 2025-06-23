@extends('admin.layouts.app') {{-- Assuming an admin layout exists --}}
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Contact Message Details</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Message from {{ $message->sender_name }}</h6>
            <div>
                <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to Messages
                </a>
                @if (!$message->is_read)
                    <form action="{{ route('admin.contact-messages.mark-as-read', $message) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm">Mark as Read</button>
                    </form>
                @else
                    <form action="{{ route('admin.contact-messages.mark-as-unread', $message) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-warning btn-sm">Mark as Unread</button>
                    </form>
                @endif
                <form action="{{ route('admin.contact-messages.destroy', $message) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Sender Name:</strong> {{ $message->sender_name }}</p>
                    <p><strong>Sender Email:</strong> <a href="mailto:{{ $message->sender_email }}">{{ $message->sender_email }}</a></p>
                    <p><strong>Sender Phone:</strong> {{ $message->sender_phone ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Subject:</strong> {{ $message->subject }}</p>
                    <p><strong>Submission Date:</strong> {{ $message->submission_date->format('F d, Y H:i A') }}</p>
                    <p><strong>Status:</strong>
                        @if ($message->is_read)
                            <span class="badge badge-success">Read</span>
                        @else
                            <span class="badge badge-warning">Unread</span>
                        @endif
                    </p>
                </div>
            </div>

            <hr>

            <h5>Message:</h5>
            <p>{{ $message->message }}</p>
        </div>
    </div>
</div>
@endsection