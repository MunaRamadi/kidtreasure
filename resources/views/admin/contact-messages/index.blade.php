@extends('admin.layouts.app') {{-- Assuming an admin layout exists --}}

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Contact Messages</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">All Messages</h6>
            <div class="d-flex">
                <form class="d-none d-sm-inline-block form-inline mr-auto my-2 my-md-0 mw-100 navbar-search" action="{{ route('admin.contact-messages.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <form class="form-inline ml-3" action="{{ route('admin.contact-messages.index') }}" method="GET">
                    <label class="my-1 mr-2" for="statusFilter">Status:</label>
                    <select class="custom-select my-1 mr-sm-2" id="statusFilter" name="status" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>Read</option>
                        <option value="unread" {{ request('status') == 'unread' ? 'selected' : '' }}>Unread</option>
                    </select>
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row mb-3">
                <div class="col-md-6">
                    <form id="bulkActionsForm" action="" method="POST">
                        @csrf
                        {{-- !!! تم إزالة @method('PATCH') من هنا !!! --}}
                        {{-- المسارات الجماعية (bulk actions) في routes/web.php هي POST، لذا لا نستخدم حقل _method --}}
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <select name="bulk_action" id="bulkActionSelect" class="form-control mb-2">
                                    <option value="">Select Action</option>
                                    <option value="mark_read">Mark as Read</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="button" id="applyBulkActionButton" class="btn btn-primary mb-2">Apply</button>
                            </div>
                        </div>
                        {{-- يجب أن تكون مربعات الاختيار (checkboxes) داخل هذا النموذج أو أن يتم إضافة قيمها ديناميكياً --}}
                        {{-- إذا كنت تستخدم partial view مثل _messages_table.blade.php، تأكد من تضمينه هنا --}}
                        {{-- أو تأكد أن مربعات الاختيار لها نفس الـ 'name="messages[]"' --}}
                    </form>
                </div>
            </div>

            @if($messages && $messages->count() > 0)
            <div class="table-responsive">
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
                                            @method('PATCH') {{-- هذا صحيح هنا، لأنه تحديث لحالة رسالة واحدة --}}
                                            <button type="submit" class="btn btn-success btn-sm">Mark Read</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.contact-messages.mark-as-unread', ['message' => $message->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH') {{-- هذا صحيح هنا، لأنه تحديث لحالة رسالة واحدة --}}
                                            <button type="submit" class="btn btn-warning btn-sm">Mark Unread</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.contact-messages.destroy', ['message' => $message->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                        @csrf
                                        @method('DELETE') {{-- هذا صحيح هنا، لأنه حذف رسالة واحدة --}}
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $messages->links() }}
            </div>
            @else
                <div class="alert alert-info">
                    <p class="mb-0">No contact messages found.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.getElementById('applyBulkActionButton').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default form submission

        const form = document.getElementById('bulkActionsForm');
        const selectedAction = document.getElementById('bulkActionSelect').value;
        const selectedMessages = Array.from(document.querySelectorAll('input[name=\"messages[]\"]:checked')).map(checkbox => checkbox.value);

        if (selectedMessages.length === 0) {
            alert('Please select at least one message.');
            return;
        }

        // إزالة أي حقول "messages[]" مخفية سابقة لمنع التكرار في كل إرسال
        form.querySelectorAll('input[name=\"messages[]\"][type=\"hidden\"]').forEach(input => input.remove());

        // إضافة حقول الإدخال المخفية للمعرفات المختارة
        selectedMessages.forEach(messageId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'messages[]'; // يجب أن يكون هذا الاسم متطابقًا مع ما يتوقعه المتحكم
            input.value = messageId;
            form.appendChild(input);
        });

        // تعيين الـ action الصحيح للنموذج بناءً على الإجراء المختار
        if (selectedAction === 'mark_read') {
            form.action = "{{ route('admin.contact-messages.bulk-mark-as-read') }}";
            // لا حاجة لتعيين _method هنا، لأن هذا المسار Route::post في web.php
            form.submit();
        } else if (selectedAction === 'delete') {
            if (confirm('Are you sure you want to delete the selected messages? This action cannot be undone.')) {
                form.action = "{{ route('admin.contact-messages.bulk-delete') }}";
                // لا حاجة لتعيين _method هنا، لأن هذا المسار Route::post في web.php
                form.submit();
            }
        } else {
            alert('Please select an action.');
            // لا حاجة لإزالة الحقول المخفية هنا لأنها ستتم إزالتها في بداية الدالة
        }
    });

    document.getElementById('checkAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name=\"messages[]\"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>
@endsection