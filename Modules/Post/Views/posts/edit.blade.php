@extends('layouts.app')

@section('title', 'ویرایش نوشته - Note Me')

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* استایل‌های قبلی شما بدون تغییر */
.edit-page {
    background: #f8fafc;
    min-height: calc(100vh - 80px);
    direction: rtl;
}

.edit-hero {
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 60px 0 40px;
    margin-bottom: 0;
    overflow: hidden;
}

.hero-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.05)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 20px;
}

.breadcrumb-link {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 5px;
    padding: 5px 8px;
    border-radius: 5px;
}

.breadcrumb-link:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    text-decoration: none;
}

.breadcrumb-separator {
    color: rgba(255, 255, 255, 0.6);
    margin: 0 5px;
}

.breadcrumb-current {
    color: white;
    font-weight: 500;
}

.page-title h1 {
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0 0 10px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.page-title p {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
    margin: 0;
}

.edit-wrapper {
    padding: 40px 0;
}

.edit-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 40px;
    align-items: start;
}

.form-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.form-header {
    padding: 30px 30px 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-bottom: 1px solid #e2e8f0;
}

.form-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-header p {
    color: #718096;
    margin: 0;
    font-size: 0.95rem;
}

.custom-alert {
    margin: 20px 30px;
    padding: 15px 20px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    animation: slideIn 0.3s ease;
}

.success-alert {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border: 1px solid #b8dabd;
    color: #155724;
}

.error-alert {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    border: 1px solid #f1b0b7;
    color: #721c24;
}

.alert-content {
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-close {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    transition: background 0.3s ease;
}

.alert-close:hover {
    background: rgba(0, 0, 0, 0.1);
}

.edit-form {
    padding: 30px;
}

.form-group {
    margin-bottom: 30px;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 12px;
    font-size: 1rem;
}

.input-wrapper,
.textarea-wrapper {
    position: relative;
}

.form-input,
.form-textarea,
.form-select {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 1rem;
    background: #fafafa;
    transition: all 0.3s ease;
    resize: none;
    font-family: inherit;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: #667eea;
    background: white;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-input.error,
.form-textarea.error,
.form-select.error {
    border-color: #e53e3e;
    background: #fff5f5;
}

.form-textarea {
    min-height: 250px;
    line-height: 1.6;
}

.character-count {
    position: absolute;
    bottom: 10px;
    left: 15px;
    font-size: 0.85rem;
    color: #718096;
    background: white;
    padding: 2px 8px;
    border-radius: 15px;
    border: 1px solid #e2e8f0;
}

.error-message {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #e53e3e;
    font-size: 0.85rem;
    margin-top: 8px;
    font-weight: 500;
}

.form-hint {
    display: flex;
    align-items: center;
    gap: 6px;
    color: #718096;
    font-size: 0.8rem;
    margin-top: 8px;
}

.form-actions {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

.btn-outline {
    background: white;
    color: #667eea;
    border: 2px solid #667eea;
}

.btn-outline:hover {
    background: #667eea;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

.info-section {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.info-card,
.stats-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.info-header,
.stats-header {
    padding: 20px 25px;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-bottom: 1px solid #e2e8f0;
}

.info-header h3,
.stats-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.info-content {
    padding: 25px;
}

.tip-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.tip-item:last-child {
    margin-bottom: 0;
}

.tip-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.tip-text h4 {
    font-size: 1rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0 0 5px;
}

.tip-text p {
    font-size: 0.9rem;
    color: #718096;
    margin: 0;
    line-height: 1.5;
}

.stats-content {
    padding: 20px 25px;
    display: grid;
    grid-template-columns: 1fr;
    gap: 15px;
}

.stat-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px;
    background: #f8fafc;
    border-radius: 10px;
    position: relative;
}

.stat-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2d3748;
}

.stat-label {
    font-size: 0.85rem;
    color: #718096;
    margin-top: 2px;
}

.stat-icon {
    font-size: 1.5rem;
    color: #667eea;
    opacity: 0.7;
}

@keyframes slideIn {
    from {
        transform: translateY(-10px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@media (max-width: 1024px) {
    .edit-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .info-section {
        order: -1;
    }
}

@media (max-width: 768px) {
    .edit-hero {
        padding: 40px 0 20px;
    }
    
    .page-title h1 {
        font-size: 2rem;
    }
    
    .edit-wrapper {
        padding: 20px 0;
    }
    
    .container {
        padding: 0 15px;
    }
    
    .form-header,
    .edit-form {
        padding: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        justify-content: center;
    }
    
    .breadcrumb-nav {
        flex-wrap: wrap;
    }
    
    .stats-content {
        padding: 15px 20px;
    }
}

@media (max-width: 480px) {
    .page-title h1 {
        font-size: 1.8rem;
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .custom-alert {
        margin: 15px 20px;
    }
}
</style>

<div class="edit-page">
    <div class="edit-hero">
        <div class="hero-backdrop"></div>
        <div class="hero-content">
            <div class="container">
                <nav class="breadcrumb-nav">
                    <a href="{{ route('home') }}" class="breadcrumb-link">
                        <i class="fas fa-home"></i>
                        خانه
                    </a>
                    <span class="breadcrumb-separator">/</span>
                    <a href="{{ route('posts.index') }}" class="breadcrumb-link">پست‌ها</a>
                    <span class="breadcrumb-separator">/</span>
                    <a href="{{ route('posts.show', $post->id) }}" class="breadcrumb-link">{{ Str::limit($post->title, 20) }}</a>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-current">ویرایش</span>
                </nav>
                <div class="page-title">
                    <h1>
                        <i class="fas fa-edit"></i>
                        ویرایش نوشته
                    </h1>
                    <p>محتوای خود را ویرایش و بهبود دهید</p>
                </div>
            </div>
        </div>
    </div>

    <div class="edit-wrapper">
        <div class="container">
            <div class="edit-grid">
                <div class="form-section">
                    <div class="form-card">
                        <div class="form-header">
                            <h2>
                                <i class="fas fa-pencil-alt"></i>
                                ویرایش محتوا
                            </h2>
                            <p>اطلاعات پست خود را بروزرسانی کنید</p>
                        </div>

                        <!-- Alert Messages -->
                        @if (session('success'))
                            <div class="custom-alert success-alert">
                                <div class="alert-content">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ session('success') }}</span>
                                </div>
                                <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="custom-alert error-alert">
                                <div class="alert-content">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                                <button type="button" class="alert-close" onclick="this.parentElement.remove()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('posts.update', $post->id) }}" class="edit-form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="title" class="form-label">
                                    <i class="fas fa-heading"></i>
                                    عنوان نوشته
                                </label>
                                <div class="input-wrapper">
                                    <input 
                                        type="text" 
                                        class="form-input {{ $errors->has('title') ? 'error' : '' }}" 
                                        id="title" 
                                        name="title" 
                                        value="{{ old('title', $post->title) }}" 
                                        placeholder="عنوان جذاب و توصیفی انتخاب کنید..."
                                        required
                                    >
                                    <div class="input-border"></div>
                                </div>
                                @error('title')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">
                                    <i class="fas fa-info-circle"></i>
                                    عنوان باید بین 5 تا 255 کاراکتر باشد
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="category_id" class="form-label">
                                    <i class="fas fa-tags"></i>
                                    دسته‌بندی
                                </label>
                                <div class="input-wrapper">
                                    <select 
                                        class="form-select {{ $errors->has('category_id') ? 'error' : '' }}" 
                                        id="category_id" 
                                        name="category_id" 
                                        required
                                    >
                                        <option value="">انتخاب دسته‌بندی</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }} ({{ $category->posts_count ?? 0 }} پست)
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-border"></div>
                                </div>
                                @error('category_id')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">
                                    <i class="fas fa-info-circle"></i>
                                    دسته‌بندی مناسب برای پست خود انتخاب کنید
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="featured_image" class="form-label">
                                    <i class="fas fa-image"></i>
                                    تصویر شاخص
                                </label>
                                @if ($post->featured_image)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Featured Image" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                @endif
                                <div class="input-wrapper">
                                    <input 
                                        type="file" 
                                        class="form-input" 
                                        id="featured_image" 
                                        name="featured_image"
                                    >
                                </div>
                                <div class="form-hint">
                                    <i class="fas fa-info-circle"></i>
                                    برای تغییر تصویر، فایل جدید را انتخاب کنید. اگر نمی‌خواهید تصویر را تغییر دهید، این قسمت را خالی بگذارید.
                                </div>
                                @error('featured_image')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content" class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    محتوای نوشته
                                </label>
                                <div class="textarea-wrapper">
                                    <textarea 
                                        class="form-textarea {{ $errors->has('content') ? 'error' : '' }}" 
                                        id="content" 
                                        name="content" 
                                        rows="12" 
                                        placeholder="محتوای خود را اینجا بنویسید..."
                                        required
                                    >{{ old('content', $post->content) }}</textarea>
                                    <div class="textarea-border"></div>
                                    <div class="character-count">
                                        <span id="charCount">{{ strlen(old('content', $post->content)) }}</span> کاراکتر
                                    </div>
                                </div>
                                @error('content')
                                    <div class="error-message">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="form-hint">
                                    <i class="fas fa-info-circle"></i>
                                    محتوا باید حداقل 10 کاراکتر داشته باشد
                                </div>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i>
                                    ذخیره تغییرات
                                    <div class="btn-ripple"></div>
                                </button>
                                
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-right"></i>
                                    بازگشت
                                </a>
                                
                                <button type="button" class="btn btn-outline" onclick="resetForm()">
                                    <i class="fas fa-undo"></i>
                                    بازگردانی
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="info-section">
                    <div class="info-card">
                        <div class="info-header">
                            <h3>
                                <i class="fas fa-lightbulb"></i>
                                راهنمای ویرایش
                            </h3>
                        </div>
                        <div class="info-content">
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div class="tip-text">
                                    <h4>عنوان جذاب</h4>
                                    <p>عنوانی انتخاب کنید که توجه خواننده را جلب کند</p>
                                </div>
                            </div>
                            
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-paragraph"></i>
                                </div>
                                <div class="tip-text">
                                    <h4>محتوای مفصل</h4>
                                    <p>مطلب خود را کامل و واضح بیان کنید</p>
                                </div>
                            </div>
                            
                            <div class="tip-item">
                                <div class="tip-icon">
                                    <i class="fas fa-spell-check"></i>
                                </div>
                                <div class="tip-text">
                                    <h4>بررسی املا</h4>
                                    <p>قبل از انتشار، املا و گرامر را بررسی کنید</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stats-card">
                        <div class="stats-header">
                            <h3>
                                <i class="fas fa-chart-bar"></i>
                                آمار پست
                            </h3>
                        </div>
                        <div class="stats-content">
                            <div class="stat-item">
                                <div class="stat-value">{{ $post->views_count ?? 0 }}</div>
                                <div class="stat-label">بازدید</div>
                                <i class="fas fa-eye stat-icon"></i>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $post->likes_count ?? 0 }}</div>
                                <div class="stat-label">لایک</div>
                                <i class="fas fa-heart stat-icon"></i>
                            </div>
                            <div class="stat-item">
                                <div class="stat-value">{{ $post->created_at->diffForHumans() }}</div>
                                <div class="stat-label">ایجاد شده</div>
                                <i class="fas fa-clock stat-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// به‌روزرسانی خودکار دسته‌بندی‌ها با AJAX
document.addEventListener('DOMContentLoaded', function() {
    async function loadCategories() {
        try {
            const response = await fetch('/api/categories');
            const result = await response.json();
            if (result.success) {
                const select = document.querySelector('#category_id');
                select.innerHTML = '<option value="">انتخاب دسته‌بندی</option>';
                result.data.forEach(category => {
                    const option = new Option(
                        `${category.name} (${category.posts_count || 0} پست ((((پست)))`,
                        category.id,
                        false,
                        category.id == '{{ old('category_id', $post->category_id) }}'
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

    // Character counter for textarea
    const textarea = document.getElementById('content');
    const charCount = document.getElementById('charCount');
    
    function updateCharCount() {
        const count = textarea.value.length;
        charCount.textContent = count.toLocaleString('fa-IR');
        
        if (count < 10) {
            charCount.style.color = '#e53e3e';
        } else if (count < 50) {
            charCount.style.color = '#dd6b20';
        } else {
            charCount.style.color = '#38a169';
        }
    }
    
    updateCharCount();
    textarea.addEventListener('input', updateCharCount);
});

// Reset form function
function resetForm() {
    if (confirm('آیا مطمئن هستید که می‌خواهید فرم را به حالت اولیه بازگردانید؟')) {
        document.querySelector('.edit-form').reset();
        document.getElementById('title').value = '{{ $post->title }}';
        document.getElementById('content').value = '{{ $post->content }}';
        document.getElementById('category_id').value = '{{ $post->category_id }}';
        
        const event = new Event('input');
        document.getElementById('content').dispatchEvent(event);
    }
}

// Auto-hide alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.custom-alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});

// Form validation
document.querySelector('.edit-form').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const content = document.getElementById('content').value.trim();
    
    if (title.length < 5) {
        e.preventDefault();
        alert('عنوان باید حداقل 5 کاراکتر داشته باشد');
        document.getElementById('title').focus();
        return;
    }
    
    if (content.length < 10) {
        e.preventDefault();
        alert('محتوا باید حداقل 10 کاراکتر داشته باشد');
        document.getElementById('content').focus();
        return;
    }
});
</script>
@endsection