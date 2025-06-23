@extends('admin.layouts.app')

@section('title', 'عرض المقال')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">عرض المقال</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.blog.edit', $post) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> تعديل
            </a>
            <form method="POST" action="{{ route('admin.blog.toggle-status', $post) }}" style="display: inline;">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn {{ $post->is_published ? 'btn-success' : 'btn-secondary' }}">
                    <i class="fas {{ $post->is_published ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                    {{ $post->is_published ? 'منشور' : 'نشر' }}
                </button>
            </form>
            <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> العودة للقائمة
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <!-- Featured Image -->
                    @if($post->image_url)
                        <div class="mb-4">
                            <img src="{{ Storage::url($post->image_url) }}" 
                                 alt="{{ $post->title_ar ?? $post->title_en }}" 
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 400px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <!-- Title -->
                    <h1 class="h2 mb-3">{{ $post->title_ar ?? $post->title_en }}</h1>

                    <!-- Excerpt -->
                    @if($post->excerpt_ar ?? $post->excerpt_en)
                        <div class="alert alert-light border-left-primary">
                            <p class="mb-0 text-muted font-italic">{{ $post->excerpt_ar ?? $post->excerpt_en }}</p>
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="content-body">
                        {!! nl2br(e($post->content_ar ?? $post->content_en)) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Post Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات المقال</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">الحالة:</div>
                        <div class="col-sm-8">
                            <span class="badge {{ $post->is_published ? 'badge-success' : 'badge-warning' }}">
                                {{ $post->is_published ? 'منشور' : 'مسودة' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">الكاتب:</div>
                        <div class="col-sm-8">{{ $post->author_name ?? 'غير محدد' }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">تاريخ النشر:</div>
                        <div class="col-sm-8">
                            {{ $post->publication_date ? $post->publication_date->format('Y-m-d H:i') : 'غير محدد' }}
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">تاريخ الإنشاء:</div>
                        <div class="col-sm-8">{{ $post->created_at->format('Y-m-d H:i') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">آخر تحديث:</div>
                        <div class="col-sm-8">{{ $post->updated_at->format('Y-m-d H:i') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">معرف المقال:</div>
                        <div class="col-sm-8">
                            <code>#{{ $post->id }}</code>
                        </div>
                    </div>

                    <!-- Word Count -->
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">عدد الكلمات:</div>
                        <div class="col-sm-8">{{ str_word_count(strip_tags($post->content_ar ?? $post->content_en)) }}</div>
                    </div>

                    <!-- Character Count -->
                    <div class="row">
                        <div class="col-sm-4 font-weight-bold">عدد الأحرف:</div>
                        <div class="col-sm-8">{{ strlen(strip_tags($post->content_ar ?? $post->content_en)) }}</div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            @if(isset($post->categories) && $post->categories->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">التصنيفات</h6>
                </div>
                <div class="card-body">
                    @foreach($post->categories as $category)
                        <span class="badge badge-primary mr-2 mb-2">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Tags -->
            @if(isset($post->tags) && $post->tags->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">الكلمات المفتاحية</h6>
                </div>
                <div class="card-body">
                    @foreach($post->tags as $tag)
                        <span class="badge badge-secondary mr-2 mb-2">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- SEO Information -->
            @if($post->meta_title || $post->meta_description || $post->meta_keywords)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات SEO</h6>
                </div>
                <div class="card-body">
                    @if($post->meta_title)
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">عنوان Meta:</div>
                        <div class="col-sm-8">{{ $post->meta_title }}</div>
                    </div>
                    @endif
                    
                    @if($post->meta_description)
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">وصف Meta:</div>
                        <div class="col-sm-8">{{ $post->meta_description }}</div>
                    </div>
                    @endif
                    
                    @if($post->meta_keywords)
                    <div class="row">
                        <div class="col-sm-4 font-weight-bold">كلمات مفتاحية:</div>
                        <div class="col-sm-8">{{ $post->meta_keywords }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">إجراءات</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if($post->is_published)
                            <a href="{{ route('blog.show', $post) }}" 
                               class="btn btn-outline-primary" 
                               target="_blank">
                                <i class="fas fa-external-link-alt"></i> عرض في الموقع
                            </a>
                        @endif
                        
                        <a href="{{ route('admin.blog.edit', $post) }}" 
                           class="btn btn-outline-warning">
                            <i class="fas fa-edit"></i> تعديل المقال
                        </a>
                        
                        <form method="POST" 
                              action="{{ route('admin.blog.destroy', $post) }}" 
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا المقال؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash"></i> حذف المقال
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .content-body {
        line-height: 1.8;
        font-size: 16px;
        color: #495057;
    }
    
    .content-body p {
        margin-bottom: 1rem;
    }
    
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    
    .badge-primary {
        background-color: #4e73df;
    }
    
    .badge-secondary {
        background-color: #858796;
    }
    
    .badge-success {
        background-color: #1cc88a;
    }
    
    .badge-warning {
        background-color: #f6c23e;
    }
</style>
@endpush
@endsection