@if($messages && $messages->count() > 0)
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th><input type="checkbox" id="checkAll"></th>
            <th>ID</th>
            <th>Sender Name</th>
            <th>Sender Email</th>
            <th>Subject</th>
            <th>Submission Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($messages as $message)
            <tr class="{{ !$message->is_read ? 'table-warning' : '' }}"> {{-- Highlight unread messages --}}
                <td><input type="checkbox" name="messages[]" value="{{ $message->id }}"></td>
                <td>{{ $message->id }}</td>
                <td>{{ $message->sender_name ?? 'N/A' }}</td>
                <td>{{ $message->sender_email ?? 'N/A' }}</td>
                <td>{{ Str::limit($message->subject ?? 'No Subject', 50) }}</td>
                <td>{{ $message->submission_date ? $message->submission_date->format('Y-m-d H:i') : 'N/A' }}</td>
                <td>
                    @if ($message->is_read)
                        <span class="badge badge-success">Read</span>
                    @else
                        <span class="badge badge-warning">Unread</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.contact-messages.show', ['message' => $message->id]) }}" class="btn btn-info btn-sm">View</a>

                    @if (!$message->is_read)
                        <form action="{{ route('admin.contact-messages.mark-as-read', ['message' => $message->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm">Mark Read</button>
                        </form>
                    @else
                        <form action="{{ route('admin.contact-messages.mark-as-unread', ['message' => $message->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-warning btn-sm">Mark Unread</button>
                        </form>
                    @endif
                    <form action="{{ route('admin.contact-messages.destroy', ['message' => $message->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
    <div class="alert alert-info">
        <p class="mb-0">No contact messages found.</p>
    </div>
@endif