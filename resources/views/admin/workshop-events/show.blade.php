@extends('admin.layouts.app')

@section('title', 'تفاصيل فعالية ورشة العمل')

@section('styles')
    <style>
        .event-image {
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .event-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .event-stats {
            background-color: #e9ecef;
            border-radius: 8px;
            padding: 15px;
        }

        .stat-card {
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
        }

        .stat-label {
            font-size: 14px;
            color: #6c757d;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid px-4" style="direction: rtl;">
        <h1 class="mt-4">تفاصيل فعالية ورشة العمل</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.workshop-events.index') }}">فعاليات ورش العمل</a></li>
            <li class="breadcrumb-item active">{{ $event->title }}</li>
        </ol>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-calendar-alt me-1"></i>
                            تفاصيل الفعالية
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if($event->image)
                                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                                        class="img-fluid event-image w-100 mb-3">
                                @else
                                    <div
                                        class="bg-light d-flex justify-content-center align-items-center event-image w-100 mb-3">
                                        <span class="text-muted">لا توجد صورة متاحة</span>
                                    </div>
                                @endif

                                <div class="event-stats">
                                    <h5 class="mb-3">إحصائيات الفعالية</h5>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="stat-card bg-primary text-white">
                                                <div class="stat-number">{{ $event->registrations_count }}</div>
                                                <div>التسجيلات</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-card bg-success text-white">
                                                <div class="stat-number">
                                                    {{ $event->max_attendees - $event->registrations_count }}
                                                </div>
                                                <div>المقاعد المتاحة</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-card bg-info text-white">
                                                <div class="stat-number">{{ $event->confirmed_count ?? 0 }}</div>
                                                <div>مؤكد</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="stat-card bg-warning text-white">
                                                <div class="stat-number">{{ $event->pending_count ?? 0 }}</div>
                                                <div>قيد الانتظار</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-grid gap-2 mt-3">
                                        @if($event->is_open_for_registration)
                                            <form action="{{ route('admin.workshop-events.toggle-registration', $event) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                                    <i class="fas fa-lock"></i> إغلاق التسجيل
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.workshop-events.toggle-registration', $event) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-success btn-sm w-100">
                                                    <i class="fas fa-lock-open"></i> فتح التسجيل
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="event-details">
                                    <h3>{{ $event->title }}</h3>

                                    @if($event->workshop_id)
                                        <div class="mb-3">
                                            <span class="badge bg-secondary">جزء من سلسلة ورش العمل:</span>
                                            <a href="{{ route('admin.workshops.show', $event->workshop_id) }}">
                                                {{ $event->workshop->title }}
                                            </a>
                                        </div>
                                    @endif

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="far fa-calendar"></i> التاريخ:</strong></p>
                                            <p>{{ $event->event_date->format('Y-m-d') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="far fa-clock"></i> الوقت:</strong></p>
                                            <p>{{ $event->event_date->format('h:i A') }}</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-users"></i> الحد الأقصى للحضور:</strong></p>
                                            <p>{{ $event->max_attendees }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-money-bill"></i> السعر:</strong></p>
                                            <p>{{ $event->price_jod }} دينار</p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-child"></i> الفئة العمرية:</strong></p>
                                            <p>{{ $event->workshop->target_age_group ?? 'غير محدد' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong><i class="fas fa-hourglass-half"></i> المدة:</strong></p>
                                            <p>{{ $event->duration_hours ?? $event->workshop->duration_hours ?? '2' }} ساعات</p>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <p class="mb-1"><strong><i class="fas fa-align-left"></i> الوصف:</strong></p>
                                        <div class="p-3 bg-white rounded">
                                            {!! $event->description !!}
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="mb-0"><small class="text-muted">تم الإنشاء:
                                                    {{ $event->created_at->format('Y-m-d H:i') }}</small></p>
                                            <p class="mb-0"><small class="text-muted">آخر تحديث:
                                                    {{ $event->updated_at->format('Y-m-d H:i') }}</small></p>
                                        </div>



                                        <div>
                                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal">
                                                <i class="fas fa-trash"></i> حذف الفعالية
                                            </button>
                                            <a href="{{ route('admin.workshop-events.edit', $event) }}"
                                                class="btn btn-primary btn-sm me-2">
                                                <i class="fas fa-edit"></i> تعديل الفعالية
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registrations Section -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-users me-1"></i>
                    تسجيلات الفعالية
                </div>
                <div>
                    <span class="badge bg-info">{{ $registrations->total() }} / {{ $event->max_attendees }} مسجل</span>
                </div>
            </div>
            <div class="card-body">
                <!-- Search and Filter Form -->
                <form action="{{ route('admin.workshop-events.show', $event) }}" method="GET" class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="ابحث بالاسم أو البريد الإلكتروني..." name="search" value="{{ request('search') }}">
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
                                <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>مستخدمون مسجلون</option>
                                <option value="guest" {{ request('type') == 'guest' ? 'selected' : '' }}>ضيوف</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">فلتر</button>
                        </div>
                    </div>
                </form>

                <!-- Registrations Table -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>الرقم</th>
                                <th>الاسم</th>
                                <th>اسم الحضور</th>
                                <th>اسم الوالد</th>
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
                                                {{ $registration->user->name }} <i class="fas fa-user-check text-success" title="مستخدم مسجل"></i>
                                            </a>
                                        @else
                                            {{ $registration->attendee_name }} <i class="fas fa-user text-secondary" title="ضيف"></i>
                                        @endif
                                    </td>
                                    <td>{{ $registration->attendee_name ?? 'N/A' }}</td>
                                    <td>{{ $registration->parent_name ?? 'N/A' }}</td>
                                    <td>
                                        @if($registration->user_id)
                                            {{ $registration->user->email }}
                                        @else
                                            {{ $registration->attendee_email ?? 'N/A' }}
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
                                                {{ ucfirst($registration->status) }}
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
                                            <i class="fas fa-trash"></i> حذف التسجيل
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
                                                    <h5>معلومات الحضور</h5>
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
                                                        
                                                        <dt class="col-sm-3">اسم الحضور:</dt>
                                                        <dd class="col-sm-9">{{ $registration->attendee_name ?? 'N/A' }}</dd>
                                                        
                                                        <dt class="col-sm-3">اسم الوالد:</dt>
                                                        <dd class="col-sm-9">{{ $registration->parent_name ?? 'N/A' }}</dd>
                                                        
                                                        <dt class="col-sm-3">البريد الإلكتروني:</dt>
                                                        <dd class="col-sm-9">
                                                            @if($registration->user_id)
                                                                {{ $registration->user->email }}
                                                            @else
                                                                {{ $registration->attendee_email ?? 'N/A' }}
                                                            @endif
                                                        </dd>
                                                        
                                                        <dt class="col-sm-3">الهاتف:</dt>
                                                        <dd class="col-sm-9">{{ $registration->parent_contact }}</dd>
                                                        
                                                        <dt class="col-sm-3">نوع التسجيل:</dt>
                                                        <dd class="col-sm-9">{{ $registration->user_id ? 'مستخدم مسجل' : 'ضيف' }}</dd>
                                                        
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
                                                                {{ ucfirst($registration->status) }}
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
                                                    </dl>
                                                    
                                                    @if($registration->notes)
                                                        <h5 class="mt-4">ملاحظات</h5>
                                                        <div class="p-3 bg-light rounded">
                                                            {{ $registration->notes }}
                                                        </div>
                                                    @endif
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
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">لا توجد تسجيلات</td>
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

        <!-- Delete Event Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">تأكيد الحذف</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>هل أنت متأكد من حذف فعالية ورشة العمل هذه: <strong>{{ $event->title }}</strong>؟</p>
                        <p class="text-danger"><strong>تحذير:</strong> سيتم حذف جميع التسجيلات المرتبطة بهذه الفعالية. لا يمكن التراجع عن هذا الإجراء.</p>
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

        <!-- Delete Registration Modals -->
        @foreach($registrations as $registration)
            <div class="modal fade" id="deleteModal{{ $registration->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $registration->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel{{ $registration->id }}">تأكيد الحذف</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>هل أنت متأكد من حذف تسجيل هذا المستخدم؟</p>
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
                                    {{ $registration->attendee_email ?? 'N/A' }}
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
        @endforeach
    </div>

@endsection

@section('scripts')
    <script>
        // Auto-close alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(function (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
@endsection