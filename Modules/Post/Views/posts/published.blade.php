```php
@extends('layouts.app')

@section('title', 'پست‌های منتشرشده - Note Me')

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* فونت و تنظیمات پایه */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.published-page {
    font-family: 'Tahoma', 'Vazir', sans-serif;
    background: #f8f9fa;
    min-height: 100vh;
    overflow-x: hidden;
}

/* بخش محتوا */
.content-section {
    padding: 80px 0;
}

.section-header {
    text-align: right;
    margin-bottom: 50px;
}

.section-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 15px;
    position: relative;
    display: inline-block;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -8px;
    right: 0;
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, #e040fb, #7b1fa2);
    border-radius: 2px;
}

.section-subtitle {
    font-size: 1rem;
    color: #6c757d;
    margin-top: 15px;
    font-weight: 300;
    text-align: right;
}

/* فرم جستجو و فیلتر */
.search-filter-form {
    margin-bottom: 30px;
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: flex-end;
}

.search-filter-form .form-control, .search-filter-form .form-select {
    border-radius: 25px;
    border: 2px solid #e9ecef;
    padding: 10px 20px;
    font-size: 0.9rem;
    width: 200px;
}

/* کارت‌های محتوا */
.content-card {
    background: white;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    height: 400px;
    position: relative;
    cursor: pointer;
    border: 2px solid transparent;
}

.content-card:hover {
    transform: translateY(-15px) scale(1.02);
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    border-color: rgba(142, 45, 226, 0.2);
}

.card-image {
    height: 180px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #7c7a7c, #ffffff);
}

.card-image i {
    font-size: 2.5rem;
    color: white;
    opacity: 0.9;
    transition: all 0.3s ease;
}

.content-card:hover .card-image i {
    transform: scale(1.1);
}

.card-content {
    padding: 25px;
    height: 220px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.card-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 15px;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-text {
    font-size: 1rem;
    color: #6c757d;
    line-height: 1.7;
    flex-grow: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.9rem;
    color: #95a5a6;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 2px solid #ecf0f1;
}

.card-meta .author {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 500;
}

.card-meta .stats {
    display: flex;
    align-items: center;
    gap: 15px;
}

.card-meta .stats span {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* تگ دسته‌بندی */
.category-tag {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.9);
    color: #2c3e50;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    backdrop-filter: blur(10px);
    z-index: 2;
}

/* دکمه بازگشت */
.back-btn {
    background: linear-gradient(135deg, #552575, #764ba2);
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 25px;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    margin-top: 30px;
    font-size: 1rem;
}

.back-btn:hover {
    background: linear-gradient(135deg, #764ba2, #7b47a5);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(142, 45, 226, 0.4);
}

/* حالت خالی */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: #6c757d;
    background: white;
    border-radius: 25px;
    margin: 20px 0;
}

.empty-state i {
    font-size: 5rem;
    margin-bottom: 30px;
    opacity: 0.3;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.empty-state h4 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    color: #2c3e50;
}

.empty-state p {
    font-size: 1.1rem;
    opacity: 0.8;
}

/* صفحه‌بندی */
.pagination {
    justify-content: center;
    margin-top: 30px;
}

.pagination .page-link {
    border-radius: 10px;
    margin: 0 5px;
    color: #667eea;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.pagination .page-link:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border-color: transparent;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-color: transparent;
    color: white;
}

/* انیمیشن‌ها */
@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* ریسپانسیو */
@media (max-width: 768px) {
    .section-title {
        font-size: 1.8rem;
    }
    
    .section-subtitle {
        font-size: 0.9rem;
    }
    
    .content-section {
        padding: 60px 0;
    }
    
    .card-content {
        padding: 20px;
    }
    
    .search-filter-form .form-control, .search-filter-form .form-select {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .content-card {
        height: auto;
        min-height: 360px;
    }
    
    .card-image {
        height: 140px;
    }
    
    .section-title {
        font-size: 1.6rem;
    }
}
</style>

<div class="published-page">
    <!-- بخش پست‌های منتشرشده -->
    <section class="content-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">پست‌های منتشرشده</h2>
                <p class="section-subtitle">لیست تمام پست‌های منتشرشده شما</p>
            </div>

            <!-- فرم جستجو و فیلتر -->
            <form class="search-filter-form" method="GET" action="{{ route('posts.published') }}">
                <input type="text" name="search" class="form-control" placeholder="جستجو در عنوان یا محتوا..." value="{{ request('search') }}">
                <select name="category_id" class="form-select">
                    <option value="">همه دسته‌بندی‌ها</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="back-btn">
                    <i class="bi bi-search"></i> جستجو
                </button>
            </form>
            
            @if($posts->count() > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="content-card" onclick="location.href='{{ route('posts.show', $post->slug ?? $post->id) }}'">
                                <div class="card-image">
                                    @php
                                        $categoryName = $post->category->name ?? '';
                                        $postTitle = $post->title ?? '';
                                        $postContent = $post->content ?? '';
                                        
                                        // تشخیص نوع پست
                                        $isNote = (
                                            str_contains($categoryName, 'دلنوشته') || 
                                            str_contains($categoryName, 'احساس') ||
                                            str_contains($categoryName, 'عشق') ||
                                            str_contains($postTitle, 'دلنوشته') ||
                                            str_contains($postTitle, 'احساس') ||
                                            str_contains($postTitle, 'عشق')
                                        );
                                        
                                        $isMovie = (
                                            str_contains($categoryName, 'فیلم') ||
                                            str_contains($categoryName, 'سینما') ||
                                            str_contains($categoryName, 'مستند') ||
                                            str_contains($postTitle, 'فیلم') ||
                                            str_contains($postTitle, 'سینما') ||
                                            str_contains($postTitle, 'مستند')
                                        );
                                        
                                        $isBook = (
                                            str_contains($categoryName, 'کتاب') ||
                                            str_contains($categoryName, 'داستان') ||
                                            str_contains($categoryName, 'رمان') ||
                                            str_contains($postTitle, 'کتاب') ||
                                            str_contains($postTitle, 'داستان') ||
                                            str_contains($postTitle, 'رمان')
                                        );
                                        
                                        $isPoem = (
                                            str_contains($categoryName, 'شعر') ||
                                            str_contains($categoryName, 'غزل') ||
                                            str_contains($categoryName, 'قطعه') ||
                                            str_contains($postTitle, 'شعر') ||
                                            str_contains($postTitle, 'غزل') ||
                                            str_contains($postTitle, 'قطعه')
                                        );
                                    @endphp
                                    
                                    @if($isNote)
                                        <i class="bi bi-heart-fill"></i>
                                    @elseif($isMovie)
                                        <i class="bi bi-camera-video-fill"></i>
                                    @elseif($isBook)
                                        <i class="bi bi-book-fill"></i>
                                    @elseif($isPoem)
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                    @endif
                                </div>
                                <div class="category-tag">
                                    @if($isNote)
                                        دلنوشته
                                    @elseif($isMovie)
                                        فیلم
                                    @elseif($isBook)
                                        کتاب
                                    @elseif($isPoem)
                                        شعر
                                    @else
                                        {{ $post->category->name ?? 'مطلب' }}
                                    @endif
                                </div>
                                <div class="card-content">
                                    <h3 class="card-title">{{ $post->title }}</h3>
                                    <p class="card-text">{{ $post->excerpt ?? \Str::limit(strip_tags($post->content), 120) }}</p>
                                    <div class="card-meta">
                                        <div class="author">
                                            <i class="bi bi-person-fill"></i>
                                            <span>{{ $post->user->name ?? 'نویسنده ناشناس' }}</span>
                                        </div>
                                        <div class="stats">
                                            <span><i class="bi bi-eye-fill"></i> {{ $post->views_count ?? 0 }}</span>
                                            <span><i class="bi bi-heart-fill"></i> {{ $post->likes_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- صفحه‌بندی -->
                <div class="pagination">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
                <div class="text-center">
                    <a href="{{ route('home') }}" class="back-btn">
                        بازگشت به صفحه اصلی
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h4>هنوز پستی منتشر نشده است</h4>
                    <p>اولین پست خود را منتشر کنید!</p>
                    @auth
                        <a href="{{ route('posts.create') }}" class="back-btn" style="margin-top: 20px;">
                            <i class="bi bi-pencil-square"></i>
                            شروع نوشتن
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </section>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// انیمیشن ورود کارت‌ها هنگام اسکرول
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// اعمال انیمیشن به تمام کارت‌ها
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.content-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px)';
        card.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });

    // اضافه کردن افکت hover به کارت‌ها
    document.querySelectorAll('.content-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.background = 'linear-gradient(135deg, #ffffff, #f8f9fa)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.background = 'white';
        });
    });
});

// اضافه کردن افکت کلیک روی کارت‌ها
document.addEventListener('click', function(e) {
    if (e.target.closest('.content-card')) {
        const card = e.target.closest('.content-card');
        card.style.transform = 'scale(0.98)';
        setTimeout(() => {
            card.style.transform = '';
        }, 150);
    }
});
</script>

@endsection
```