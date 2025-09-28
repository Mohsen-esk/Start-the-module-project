@extends('admin.layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

    .page-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .page-title {
        color: #2d3748;
        font-size: 2rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 15px;
        margin-bottom: 10px;
    }

    .page-title .icon {
        color: #667eea;
        font-size: 1.8rem;
    }

    .subtitle {
        color: #718096;
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 15px 20px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f7fafc;
        outline: none;
    }

    .form-control:focus {
        border-color: #667eea;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        transform: translateY(-2px);
    }

    .form-control:hover {
        border-color: #cbd5e0;
        background: #fff;
    }

    .btn {
        padding: 15px 25px;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-decoration: none;
        width: 100%;
        margin-bottom: 15px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        background: #e2e8f0;
        color: #4a5568;
    }

    .btn-secondary:hover {
        background: #cbd5e0;
        transform: translateY(-2px);
    }

    .alert {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-danger {
        background: #fed7d7;
        color: #c53030;
        border-right: 4px solid #e53e3e;
    }

    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        z-index: 1;
    }

    .form-control.with-icon {
        padding-right: 45px;
    }

    .help-text {
        font-size: 0.85rem;
        color: #718096;
        margin-top: 5px;
    }

    .loading {
        pointer-events: none;
        opacity: 0.7;
    }

    .spinner {
        display: none;
        width: 20px;
        height: 20px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    .loading .spinner {
        display: inline-block;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="form-container">
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-folder-plus icon"></i>
            ایجاد دسته‌بندی جدید
        </h1>
        <p class="subtitle">دسته‌بندی جدید خود را ایجاد کنید</p>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-triangle"></i>
        <div>
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
    @endif

    <form id="category-form" action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name" class="form-label">
                <i class="fas fa-tag"></i>
                نام دسته‌بندی
            </label>
            <div class="input-group">
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control with-icon" 
                    placeholder="نام دسته‌بندی را وارد کنید"
                    value="{{ old('name') }}"
                    required
                    autocomplete="off"
                >
                <i class="fas fa-folder input-icon"></i>
            </div>
            <div class="help-text">نام دسته‌بندی باید منحصر به فرد باشد</div>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">
                <i class="fas fa-align-left"></i>
                توضیحات (اختیاری)
            </label>
            <div class="input-group">
                <textarea 
                    id="description" 
                    name="description" 
                    class="form-control with-icon" 
                    placeholder="توضیحات دسته‌بندی را وارد کنید"
                    rows="4"
                    style="resize: vertical; min-height: 100px;"
                >{{ old('description') }}</textarea>
                <i class="fas fa-edit input-icon"></i>
            </div>
            <div class="help-text">توضیحات کوتاهی در مورد دسته‌بندی</div>
        </div>

        <button type="submit" class="btn btn-primary" id="submit-btn">
            <i class="fas fa-plus"></i>
            <span class="spinner"></span>
            <span class="btn-text">ایجاد دسته‌بندی</span>
        </button>

        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i>
            بازگشت به لیست
        </a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('category-form');
        const submitBtn = document.getElementById('submit-btn');
        const nameInput = document.getElementById('name');

        // Real-time validation
        nameInput.addEventListener('input', function() {
            const value = this.value.trim();
            
            if (value.length > 255) {
                this.style.borderColor = '#e53e3e';
            } else {
                this.style.borderColor = '#e2e8f0';
            }
        });

        // Form submission
        form.addEventListener('submit', function(e) {
            const nameValue = nameInput.value.trim();
            
            if (!nameValue) {
                e.preventDefault();
                nameInput.focus();
                return;
            }

            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.querySelector('.btn-text').textContent = 'در حال ایجاد...';
        });

        // Auto-focus on name input
        nameInput.focus();
    });
</script>

@endsection