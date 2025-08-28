@extends('admin.layouts.app')

@section('title', 'Event Registrations')

@section('styles')
<style>
    .status-badge {
        cursor: pointer;
    }
    .registration-details {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 15px;
    }
    .registration-info {
        margin-bottom: 0;
    }
    .registration-info dt {
        font-weight: 600;
    }
    /* RTL adjustments */
    [dir="rtl"] .me-1 {
        margin-left: 0.25rem !important;
        margin-right: 0 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-4" dir="rtl">
    <h1 class="mt-4">تسجيلات الفعالية</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.index') }}">فعاليات الورش</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.show', $event) }}">{{ $event->title }}</a></li>
        <li class="breadcrumb-item active">التسجيلات</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-users me-1"></i>
                التسجيلات لـ: {{ $event->title }}
            </div>
            <div>
                <span class="badge bg-info">{{ $registrations->total() }} / {{ $event->max_attendees }} مسجل</span>
            </div>
        </div>
        <div class="card-body">
            <!-- Event Summary -->
            <div class="alert alert-info mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <strong>التاريخ:</strong> {{ $event->event_date->format('Y-m-d') }} في {{ $event->event_date->format('h:i A') }}
                    </div>
                    <div class="col-md-4">
                        <strong>المدة:</strong> {{ $event->duration_hours }} ساعات
                    </div>
                    <div class="col-md-4">
                        <strong>الموقع:</strong> {{ $event->location }}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <strong>السعر:</strong> {{ $event->price_jod }} دينار
                    </div>
                    <div class="col-md-4">
                        <strong>الفئة العمرية:</strong> {{ $event->age_group }}
                    </div>
                    <div class="col-md-4">
                        <strong>الحالة:</strong>
                        @if($event->is_open_for_registration)
                            <span class="badge bg-success">مفتوح للتسجيل</span>
                        @else
                            <span class="badge bg-danger">مغلق</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Search and Filter Form -->
            <form action="{{ route('admin.workshop-events.registrations', $event) }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="البحث بالاسم أو البريد الإلكتروني..." name="search" value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">جميع الحالات</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                            <option value="attended" {{ request('status') == 'attended' ? 'selected' : '' }}>حضر</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-select">
                            <option value="">جميع الأنواع</option>
                            <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>مستخدمين مسجلين</option>
                            <option value="guest" {{ request('type') == 'guest' ? 'selected' : '' }}>زوار</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">تصفية</button>
                    </div>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>الرقم</th>
                            <th>الاسم</th>
                            <th>اسم المشارك</th>
                            <th>اسم الوالد/ة</th>
                            <th>البريد الإلكتروني</th>
                            <th>الهاتف</th>
                            <th>تاريخ التسجيل</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $registration)
                            <tr>
                                <td>{{ $registration->id }}</td>
                                <td>
                                    @if($registration->user_id)
                                        <a href="{{ route('admin.users.show', $registration->user_id) }}">
                                            {{ $registration->user->name }}
                                        </a>
                                        <span class="badge bg-primary">مستخدم</span>
                                    @else
                                        {{ $registration->attendee_name }}
                                        <span class="badge bg-secondary">زائر</span>
                                    @endif
                                </td>
                                <td>{{ $registration->attendee_name ?? 'غير متوفر' }}</td>
                                <td>{{ $registration->parent_name ?? 'غير متوفر' }}</td>
                                <td>
                                    @if($registration->user_id)
                                        {{ $registration->user->email }}
                                    @else
                                        {{ $registration->attendee_email ?? 'غير متوفر' }}
                                    @endif
                                </td>
                                <td>{{ $registration->parent_contact }}</td>
                                <td>{{ $registration->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <span class="badge status-badge dropdown-toggle 
                                            @if($registration->status == 'confirmed') bg-success 
                                            @elseif($registration->status == 'pending') bg-warning text-dark 
                                            @elseif($registration->status == 'cancelled') bg-danger 
                                            @elseif($registration->status == 'attended') bg-info 
                                            @endif" 
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            @switch($registration->status)
                                                @case('pending')
                                                    قيد الانتظار
                                                    @break
                                                @case('confirmed')
                                                    مؤكد
                                                    @break
                                                @case('cancelled')
                                                    ملغي
                                                    @break
                                                @case('attended')
                                                    حضر
                                                    @break
                                                @default
                                                    {{ $registration->status }}
                                            @endswitch
                                        </span>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="pending">
                                                    <button type="submit" class="dropdown-item">قيد الانتظار</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="dropdown-item">مؤكد</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="cancelled">
                                                    <button type="submit" class="dropdown-item">ملغي</button>
                                                </form>
                                            </li>
                                            <li>
                                                <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="attended">
                                                    <button type="submit" class="dropdown-item">حضر</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $registration->id }}">
                                        <i class="fas fa-info-circle"></i> التفاصيل
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $registration->id }}">
                                        <i class="fas fa-trash"></i> إزالة
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Registration Details Modal -->
                            <div class="modal fade" id="detailsModal{{ $registration->id }}" tabindex="-1" aria-labelledby="detailsModalLabel{{ $registration->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailsModalLabel{{ $registration->id }}">تفاصيل التسجيل</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="registration-details">
                                                <h5>معلومات المشارك</h5>
                                                <dl class="row registration-info">
                                                    <dt class="col-sm-3">رقم التسجيل:</dt>
                                                    <dd class="col-sm-9">{{ $registration->id }}</dd>
                                                    
                                                    <dt class="col-sm-3">الاسم:</dt>
                                                    <dd class="col-sm-9">
                                                        @if($registration->user_id)
                                                            {{ $registration->user->name }}
                                                        @else
                                                            {{ $registration->attendee_name }}
                                                        @endif
                                                    </dd>
                                                    
                                                    <dt class="col-sm-3">اسم المشارك:</dt>
                                                    <dd class="col-sm-9">{{ $registration->attendee_name ?? 'غير متوفر' }}</dd>
                                                    
                                                    <dt class="col-sm-3">اسم الوالد/ة:</dt>
                                                    <dd class="col-sm-9">{{ $registration->parent_name ?? 'غير متوفر' }}</dd>
                                                    
                                                    <dt class="col-sm-3">البريد الإلكتروني:</dt>
                                                    <dd class="col-sm-9">
                                                        @if($registration->user_id)
                                                            {{ $registration->user->email }}
                                                        @else
                                                            {{ $registration->attendee_email ?? 'غير متوفر' }}
                                                        @endif
                                                    </dd>
                                                    
                                                    <dt class="col-sm-3">الهاتف:</dt>
                                                    <dd class="col-sm-9">{{ $registration->parent_contact }}</dd>
                                                    
                                                    <dt class="col-sm-3">نوع التسجيل:</dt>
                                                    <dd class="col-sm-9">{{ $registration->user_id ? 'مستخدم مسجل' : 'زائر' }}</dd>
                                                    
                                                    <dt class="col-sm-3">تاريخ التسجيل:</dt>
                                                    <dd class="col-sm-9">{{ $registration->created_at->format('Y-m-d H:i:s') }}</dd>
                                                    
                                                    <dt class="col-sm-3">الحالة:</dt>
                                                    <dd class="col-sm-9">
                                                        <span class="badge 
                                                            @if($registration->status == 'confirmed') bg-success 
                                                            @elseif($registration->status == 'pending') bg-warning text-dark 
                                                            @elseif($registration->status == 'cancelled') bg-danger 
                                                            @elseif($registration->status == 'attended') bg-info 
                                                            @endif">
                                                            @switch($registration->status)
                                                                @case('pending')
                                                                    قيد الانتظار
                                                                    @break
                                                                @case('confirmed')
                                                                    مؤكد
                                                                    @break
                                                                @case('cancelled')
                                                                    ملغي
                                                                    @break
                                                                @case('attended')
                                                                    حضر
                                                                    @break
                                                                @default
                                                                    {{ $registration->status }}
                                                            @endswitch
                                                        </span>
                                                    </dd>
                                                    
                                                    @if($registration->special_requirements)
                                                        <dt class="col-sm-3">متطلبات خاصة:</dt>
                                                        <dd class="col-sm-9">{{ $registration->special_requirements }}</dd>
                                                    @endif
                                                    
                                                    @if($registration->user_id)
                                                        <dt class="col-sm-3">حساب المستخدم:</dt>
                                                        <dd class="col-sm-9">
                                                            <a href="{{ route('admin.users.show', $registration->user_id) }}">
                                                                عرض ملف المستخدم <i class="fas fa-external-link-alt"></i>
                                                            </a>
                                                        </dd>
                                                    @endif
                                                    
                                                    @if($registration->event)
                                                        <dt class="col-sm-3">الفعالية:</dt>
                                                        <dd class="col-sm-9">
                                                            <a href="{{ route('admin.workshop-events.show', $registration->event_id) }}">
                                                                {{ $registration->event->title }}
                                                            </a>
                                                        </dd>
                                                    @endif
                                                </dl>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    تحديث الحالة
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="pending">
                                                            <button type="submit" class="dropdown-item">قيد الانتظار</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="confirmed">
                                                            <button type="submit" class="dropdown-item">مؤكد</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit" class="dropdown-item">ملغي</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.workshop-events.registrations.update-status', $registration) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="attended">
                                                            <button type="submit" class="dropdown-item">حضر</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Delete Registration Modal -->
                            <div class="modal fade" id="deleteModal{{ $registration->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $registration->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $registration->id }}">تأكيد الحذف</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>هل أنت متأكد من رغبتك في إزالة هذا التسجيل؟</p>
                                            <p><strong>الاسم:</strong> 
                                                @if($registration->user_id)
                                                    {{ $registration->user->name }}
                                                @else
                                                    {{ $registration->attendee_name }}
                                                @endif
                                            </p>
                                            <p><strong>البريد الإلكتروني:</strong> 
                                                @if($registration->user_id)
                                                    {{ $registration->user->email }}
                                                @else
                                                    {{ $registration->attendee_email ?? 'غير متوفر' }}
                                                @endif
                                            </p>
                                            <p class="text-danger">لا يمكن التراجع عن هذا الإجراء.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                                            <form action="{{ route('admin.workshop-events.registrations.destroy', $registration->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">حذف التسجيل</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">لم يتم العثور على تسجيلات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $registrations->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-close alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endsection
