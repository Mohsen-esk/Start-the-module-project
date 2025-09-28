{{-- resources/views/posts/create.blade.php --}}
@extends('layouts.app')

@section('title', 'افزودن نوشته جدید - Note Me')

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* تنظیمات راست‌چین */
    .create-post-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 30px 0;
    }

    .page-header h1 {
        background: linear-gradient(135deg, #22022c 0%, #200427 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .page-header p {
        color: #fffcff;
        font-size: 1.1rem;
    }

    .form-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(180, 5, 224, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.8);
        position: relative;
        animation: fadeInUp 0.6s ease-out;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        height: 5px;
        background: linear-gradient(135deg, #a42fe7 0%, #ca90cc 100%);
    }

    .form-group {
        margin-bottom: 25px;
        animation: fadeInRight 0.6s ease-out;
        animation-fill-mode: both;
        transform: translateZ(0);
    }

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }

    .form-label {
        font-weight: 600;
        color: #841888;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-control {
        border: 2px solid #b824d6;
        border-radius: 12px;
        padding: 15px 20px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8faf8;
    }

    .form-control:focus {
        border-color: #667eea;
        background: white;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.1);
    }

    .form-control:hover {
        border-color: #ced4da;
        background: white;
    }

    textarea.form-control {
        min-height: 200px;
        resize: vertical;
    }

    .btn-group-custom {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
    }

    .btn-custom {
        background: linear-gradient(135deg, #c547ff 0%, #bb9ace 100%);
        border: none;
        border-radius: 25px;
        padding: 15px 30px;
        color: white;
        font-weight: bold;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-custom:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-secondary-custom {
        background: #8105b3;
        border: none;
        border-radius: 25px;
        padding: 15px 30px;
        color: white;
        font-weight: bold;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-secondary-custom:hover {
        background: #5a6268;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .alert-custom {
        border-radius: 12px;
        margin-bottom: 25px;
        border: none;
        padding: 15px 20px;
    }

    .alert-success-custom {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-right: 4px solid #28a745;
    }

    .text-danger-custom {
        color: #dc3545;
        font-size: 0.9rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .input-icon {
        position: relative;
    }

    .input-icon i {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 5;
    }

    .input-icon .form-control {
        padding-right: 45px;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .create-post-container {
            padding: 15px;
        }

        .form-card {
            padding: 25px 20px;
        }

        .page-header h1 {
            font-size: 2rem;
        }

        .btn-group-custom {
            flex-direction: column;
            align-items: center;
        }

        .btn-custom,
        .btn-secondary-custom {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .form-card {
            border-radius: 15px;
            padding: 20px 15px;
        }

        .page-header {
            padding: 20px 0;
            margin-bottom: 25px;
        }
    }
</style>

<div class="create-post-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>
            <i class="bi bi-pencil-square"></i>
            افزودن نوشته جدید
        </h1>
        <p>افکار و احساسات خود را با دنیا به اشتراک بگذارید</p>
    </div>

    <!-- Form Card -->
    <div class="form-card">
        @if (session('success'))
            <div class="alert alert-success-custom alert-custom" role="alert">
                <i class="bi bi-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger-custom alert-custom" role="alert">
                <i class="bi bi-exclamation-circle"></i>
                خطاهایی در فرم وجود دارد:
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title" class="form-label">
                    <i class="bi bi-bookmark"></i>
                    عنوان نوشته
                </label>
                <div class="input-icon">
                    <input type="text" 
                           class="form-control" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}" 
                           placeholder="عنوان جذاب و خلاقانه انتخاب کنید..."
                           required>
                    <i class="bi bi-type"></i>
                </div>
                @error('title')
                    <div class="text-danger-custom">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id" class="form-label">
                    <i class="bi bi-tags"></i>
                    دسته‌بندی
                </label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">انتخاب دسته‌بندی</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="text-danger-custom">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="featured_image" class="form-label">
                    <i class="bi bi-image"></i>
                    تصویر شاخص
                </label>
                <input type="file" class="form-control" id="featured_image" name="featured_image">
                @error('featured_image')
                    <div class="text-danger-custom">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="content" class="form-label">
                    <i class="bi bi-textarea"></i>
                    محتوای نوشته
                </label>
                <textarea class="form-control" 
                          id="content" 
                          name="content" 
                          placeholder="داستان، شعر، دلنوشته یا هر چیز دیگری که دوست دارید بنویسید..."
                          required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="text-danger-custom">
                        <i class="bi bi-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="btn-group-custom">
                <button type="submit" class="btn-custom">
                    <i class="bi bi-check-circle"></i>
                    ذخیره نوشته
                </button>
                <a href="{{ route('posts.index') }}" class="btn-secondary-custom">
                    <i class="bi bi-arrow-right"></i>
                    بازگشت به نوشته‌ها
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // به‌روزرسانی خودکار دسته‌بندی‌ها با AJAX
        async function loadCategories() {
            try {
                const response = await fetch('/api/categories');
                const result = await response.json();
                if (result.success) {
                    const select = document.querySelector('#category_id');
                    select.innerHTML = '<option value="">انتخاب دسته‌بندی</option>';
                    result.data.forEach(category => {
                        const option = new Option(
                            category.name,
                            category.id,
                            false,
                            category.id == '{{ old('category_id') }}'
                        );
                        select.appendChild(option);
                    });
                }
            } catch (error) {
                console.error('Error loading categories:', error);
            }
        }

        // فراخوانی اولیه
        loadCategories();

        // گوش دادن به رویداد categoryCreated
        document.addEventListener('categoryCreated', loadCategories);

        // افکت‌های تعاملی
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentNode.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentNode.classList.remove('focused');
            });
        });

        // Auto-resize textarea
        const textarea = document.getElementById('content');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.max(200, this.scrollHeight) + 'px';
            });
        }

        // Form validation animation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = document.querySelector('.btn-custom');
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> در حال ذخیره...';
                submitBtn.disabled = true;
            });
        }
    });
</script>
@endsection