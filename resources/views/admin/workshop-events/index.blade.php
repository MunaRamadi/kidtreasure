@extends('admin.layouts.app')

@section('title', 'فعاليات الورش')

@section('content')
<div class="container-fluid px-4" style="direction: rtl;">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">إدارة فعاليات الورش</h1>
        <a href="{{ route('admin.workshop-events.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة فعالية جديدة
        </a>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">قائمة فعاليات الورش</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.workshop-events.index') }}" method="GET" class="row g-3">
                <div class="col-md-2">
                    <label for="search" class="form-label">البحث</label>
                    <input type="text" class="form-control" id="search" name="search" 
                        placeholder="البحث عن طريق العنوان" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_from" class="form-label">التاريخ من</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" 
                        value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label for="date_to" class="form-label">التاريخ إلى</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" 
                        value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">حالة التسجيل</label>
                    <select class="form-select form-control" id="status" name="status">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>الكل</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>مفتوح</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلق</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="event_status" class="form-label">حالة الفعالية</label>
                    <select class="form-select form-control" id="event_status" name="event_status">
                        <option value="all" {{ request('event_status') == 'all' ? 'selected' : '' }}>الكل</option>
                        <option value="upcoming" {{ request('event_status') == 'upcoming' ? 'selected' : '' }}>قادمة</option>
                        <option value="in_progress" {{ request('event_status') == 'in_progress' ? 'selected' : '' }}>جارية</option>
                        <option value="completed" {{ request('event_status') == 'completed' ? 'selected' : '' }}>منتهية</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="sort" class="form-label">ترتيب حسب</label>
                    <select class="form-select form-control" id="sort" name="sort">
                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>التاريخ (الأحدث)</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>التاريخ (الأقدم)</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>العنوان (أ-ي)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>العنوان (ي-أ)</option>
                        <option value="registrations" {{ request('sort') == 'registrations' ? 'selected' : '' }}>أكثر التسجيلات</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">تصفية</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Workshop Events Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">فعاليات الورش</h6>
        </div>
        <div class="card-body">
            @if($workshops->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>التاريخ</th>
                                <th>الموقع</th>
                                <th>السعر (دينار)</th>
                                <th>التسجيلات</th>
                                <th>حالة الفعالية</th>
                                <th>حالة التسجيل</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workshops as $workshop)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.workshop-events.show', $workshop) }}">
                                            {{ $workshop->title }}
                                        </a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($workshop->event_date)->format('d M Y, h:i A') }}</td>
                                    <td>{{ $workshop->location }}</td>
                                    <td>{{ number_format($workshop->price_jod, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.workshop-events.registrations', $workshop) }}">
                                            {{ $workshop->registrations_count }} / {{ $workshop->max_attendees }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge {{ $workshop->status === 'upcoming' ? 'bg-primary' : ($workshop->status === 'in_progress' ? 'bg-warning text-dark' : 'bg-success') }}">
                                            {{ ucfirst($workshop->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.workshop-events.toggle-registration', $workshop) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm {{ $workshop->is_open_for_registration ? 'btn-success' : 'btn-danger' }}" 
                                                data-bs-toggle="tooltip" title="Click to {{ $workshop->is_open_for_registration ? 'close' : 'open' }} registration">
                                                {{ $workshop->is_open_for_registration ? 'Open' : 'Closed' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.workshop-events.show', $workshop) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.workshop-events.edit', $workshop) }}" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $workshop->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $workshop->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $workshop->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content" dir="rtl">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $workshop->id }}">تأكيد الحذف</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        هل أنت متأكد من رغبتك في حذف الفعالية "{{ $workshop->title }}"؟
                                                        @if($workshop->registrations_count > 0)
                                                            <div class="alert alert-warning mt-3">
                                                                <i class="fas fa-exclamation-triangle"></i> هذه الفعالية لديها {{ $workshop->registrations_count }} تسجيل. يجب إزالة جميع التسجيلات قبل حذف هذه الفعالية.
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                                        <form action="{{ route('admin.workshop-events.destroy', $workshop) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">حذف</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $workshops->links() }}
                </div>
                @else
                <div class="alert alert-info">
                    لم يتم العثور على فعاليات ورش. <a href="{{ route('admin.workshop-events.create') }}">إنشاء أول فعالية ورشة</a>.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize date pickers if needed
        if ($.fn.flatpickr) {
            $("#date_from, #date_to").flatpickr({
                dateFormat: "Y-m-d",
            });
        }
    });
</script>
@endsection
