@extends('admin.layouts.app')

@section('title', 'تفاصيل الورشة')

@section('content')
<div class="container-fluid px-4" style="direction: rtl;">
    <h1 class="mt-4">تفاصيل الورشة</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshops.index') }}">الورش</a></li>
        <li class="breadcrumb-item active">{{ $workshop->name_ar }}</li>
    </ol>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Workshop Information Card -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-info-circle me-1"></i>
                        معلومات الورشة
                    </div>
                    <div>
                        <a href="{{ route('admin.workshops.edit', $workshop) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> تعديل
                        </a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash"></i> حذف
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h5>الاسم بالعربية</h5>
                            <p dir="rtl">{{ $workshop->name_ar }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>الاسم بالإنجليزية</h5>
                            <p>{{ $workshop->name_en }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>الحالة</h5>
                            @if($workshop->is_active)
                                <span class="badge bg-success">نشط</span>
                            @else
                                <span class="badge bg-danger">غير نشط</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>الفئة العمرية المستهدفة</h5>
                            <p>{{ $workshop->target_age_group }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>الوصف بالعربية</h5>
                            <div class="border rounded p-3 bg-light" dir="rtl">
                                {{ $workshop->description_ar }}
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>الوصف بالإنجليزية</h5>
                            <div class="border rounded p-3 bg-light">
                                {{ $workshop->description_en }}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>تاريخ الإنشاء</h5>
                            <p>{{ $workshop->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>آخر تحديث</h5>
                            <p>{{ $workshop->updated_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Workshop Events Card -->
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-calendar me-1"></i>
                        فعاليات الورشة
                    </div>
                    <a href="{{ route('admin.workshop-events.create', ['workshop_id' => $workshop->id, 'redirect_to' => 'workshop']) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> إضافة فعالية
                    </a>
                </div>
                <div class="card-body">
                    @if($workshop->events->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>الوقت</th>
                                        <th>المكان</th>
                                        <th>السعر (دينار)</th>
                                        <th>الحضور</th>
                                        <th>الحالة</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workshop->events as $event)
                                        <tr>
                                            <td>{{ $event->event_date->format('Y-m-d') }}</td>
                                            <td>{{ $event->event_time->format('H:i') }}</td>
                                            <td>{{ $event->location }}</td>
                                            <td>{{ number_format($event->price_jod, 2) }}</td>
                                            <td>
                                                {{ $event->current_attendees }} / {{ $event->max_attendees }}
                                                <div class="progress mt-1" style="height: 5px;">
                                                    <div class="progress-bar bg-info" role="progressbar" 
                                                        style="width: {{ ($event->current_attendees / $event->max_attendees) * 100 }}%;" 
                                                        aria-valuenow="{{ $event->current_attendees }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="{{ $event->max_attendees }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($event->is_open_for_registration)
                                                    <span class="badge bg-success">مفتوح</span>
                                                @else
                                                    <span class="badge bg-danger">مغلق</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.workshop-events.show', $event) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-eye"></i> تفاصيل
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            لم يتم جدولة أي فعاليات لهذه الورشة بعد.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد من رغبتك في حذف الورشة "{{ $workshop->name_ar }}"؟ سيؤدي هذا أيضًا إلى حذف جميع الفعاليات والتسجيلات المرتبطة بها.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('admin.workshops.destroy', $workshop) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Event Modals -->
    @foreach($workshop->events as $event)
    <div class="modal fade" id="deleteEventModal{{ $event->id }}" tabindex="-1" aria-labelledby="deleteEventModalLabel{{ $event->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteEventModalLabel{{ $event->id }}">تأكيد حذف الفعالية</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    هل أنت متأكد من رغبتك في حذف الفعالية المجدولة بتاريخ {{ $event->event_date->format('Y-m-d') }} في الساعة {{ $event->event_time->format('H:i') }}؟
                    @if($event->registrations_count > 0)
                    <div class="alert alert-warning mt-2">
                        <strong>تحذير:</strong> تحتوي هذه الفعالية على {{ $event->registrations_count }} تسجيل سيتم حذفها أيضًا.
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <form action="{{ route('admin.workshop-events.destroy', $event) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">حذف الفعالية</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('scripts')
<script>
    // Auto-close alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-success');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection