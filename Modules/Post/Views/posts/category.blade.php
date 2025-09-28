```blade
@extends('layouts.app')

@section('title', ($categoryName ?? 'دسته‌بندی') . ' - Note Me')

@section('content')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<div class="category-page">
    <!-- Hero Section with Glassmorphism -->
    <div class="page-hero">
        <div class="hero-background">
            <div class="hero-pattern"></div>
            <div class="floating-elements">
                <div class="float-element float-1"></div>
                <div class="float-element float-2"></div>
                <div class="float-element float-3"></div>
                <div class="float-element float-4"></div>
            </div>
        </div>
        <div class="hero-content">
            <div class="hero-glass-card">
                <h1 class="hero-title">
                    <span class="title-text">{{ $categoryName ?? 'دسته‌بندی' }}</span>
                    <div class="title-underline"></div>
                </h1>
                <p class="hero-subtitle">{{ $categoryDescription ?? 'مجموعه‌ای از آثار مرتبط' }}</p>
                <div class="hero-decoration">
                    <i class="bi bi-feather"></i>
                </div>
            </div>
        </div>
        <div class="hero-scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </div>

    <!-- Success Alert -->
    @if (session('success'))
    <div class="custom-alert custom-alert-success" id="successAlert">
        <div class="alert-content">
            <div class="alert-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="alert-text">{{ session('success') }}</div>
            <button type="button" class="alert-dismiss" onclick="hideAlert()">
                <i class="bi bi-x"></i>
            </button>
        </div>
    </div>
    @endif

    <div class="posts-container">
        <div class="posts-grid">
            @forelse ($posts as $post)
                <article class="poetry-card" data-aos="fade-up">
                    <div class="card-background"></div>
                    <div class="card-content">
                        <div class="card-header">
                            <h2 class="card-title">{{ $post->title }}</h2>
                            <div class="card-bookmark">
                                <i class="bi bi-bookmark"></i>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <p class="card-excerpt">
                                {{ \Str::limit(strip_tags($post->content), 150) }}
                            </p>
                        </div>
                        
                        <div class="card-meta">
                            <div class="meta-row">
                                <div class="author-info">
                                    <div class="author-avatar">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                    <div class="author-details">
                                        <span class="author-name">{{ $post->user->nickname ?? $post->user->name ?? 'ناشناس' }}</span>
                                        <span class="publish-date">{{ $post->created_at->format('Y/m/d') }}</span>
                                    </div>
                                </div>
                                @if ($post->category)
                                    <div class="category-tag {{ Str::slug($post->category->name) }}-tag">
                                        <i class="bi bi-tag-fill"></i>
                                        {{ $post->category->name }}
                                    </div>
                                @endif
                            </div>
                            <div class="card-stats">
                                <div class="stat">
                                    <i class="bi bi-eye-fill"></i>
                                    <span>{{ $post->views_count ?? 0 }}</span>
                                </div>
                                <div class="stat">
                                    <i class="bi bi-heart-fill"></i>
                                    <span>{{ $post->likes_count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-actions">
                            <a href="{{ route('posts.show', $post->slug ?? $post->id) }}" class="action-btn primary">
                                <span>ادامه مطلب</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                            @auth
                                @if (Auth::id() === $post->user_id)
                                    <a href="{{ route('posts.edit', $post->id) }}" class="action-btn">
                                        <span>ویرایش</span>
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('posts.save', $post) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="action-btn">
                                            @if(Auth::check() && Auth::user()->savedPosts->contains($post))
                                                <i class="bi bi-bookmark-fill"></i>
                                                <span>ذخیره شده</span>
                                            @else
                                                <i class="bi bi-bookmark"></i>
                                                <span>ذخیره</span>
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn danger" onclick="return confirm('آیا مطمئن هستید؟');">
                                            <span>حذف</span>
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-content">
                    <div class="empty-icon">
                        <i class="bi bi-book"></i>
                    </div>
                    <h3 class="empty-title">هنوز پستی منتشر نشده</h3>
                    <p class="empty-text">اولین نفری باشید که نوشته خود را با دنیا به اشتراک می‌گذارد</p>
                </div>
            @endforelse
        </div>

        @auth
        <div class="create-section">
            <div class="create-glass-card">
                <div class="create-content">
                    <div class="create-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <h3 class="create-title">نوشته‌ای دارید؟</h3>
                    <p class="create-text">آیا داستان، شعر یا دلنوشته‌ای دارید که می‌خواهید با دیگران به اشتراک بگذارید؟</p>
                    <a href="{{ route('posts.create') }}" class="create-btn">
                        <span>افزودن نوشته جدید</span>
                        <i class="bi bi-plus-circle"></i>
                    </a>
                </div>
                <div class="create-decoration">
                    <div class="deco-circle deco-1"></div>
                    <div class="deco-circle deco-2"></div>
                    <div class="deco-circle deco-3"></div>
                </div>
            </div>
        </div>
        @else
        <div class="create-section">
            <div class="create-glass-card">
                <div class="create-content">
                    <div class="create-icon">
                        <i class="bi bi-box-arrow-in-right"></i>
                    </div>
                    <h3 class="create-title">عضویت داشته باشید</h3>
                    <p class="create-text">برای اشتراک‌گذاری نوشته‌های خود، ابتدا وارد حساب کاربری شوید</p>
                    <a href="{{ route('login') }}" class="create-btn">
                        <span>ورود به حساب کاربری</span>
                        <i class="bi bi-box-arrow-in-right"></i>
                    </a>
                </div>
                <div class="create-decoration">
                    <div class="deco-circle deco-1"></div>
                    <div class="deco-circle deco-2"></div>
                    <div class="deco-circle deco-3"></div>
                </div>
            </div>
        </div>
        @endauth

        @if(method_exists($posts, 'links'))
        <div class="pagination-section">
            {{ $posts->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Vazirmatn', sans-serif;
    background: #4C2A85;
    min-height: 100vh;
    overflow-x: hidden;
}

.category-page {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --secondary-gradient: linear-gradient(135deg, #764ba2 0%, #f093fb 100%);
    --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --glass-bg: rgba(255, 255, 255, 0.15);
    --glass-border: rgba(255, 255, 255, 0.2);
    --shadow-light: 0 8px 32px rgba(31, 38, 135, 0.37);
    --shadow-medium: 0 15px 35px rgba(31, 38, 135, 0.5);
    --border-radius: 20px;
    --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Hero Section */
.page-hero {
    position: relative;
    height: 60vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--primary-gradient);
}

.hero-pattern {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    animation: float 20s ease-in-out infinite;
}

.floating-elements {
    position: absolute;
    width: 100%;
    height: 100%;
}

.float-element {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
}

.float-1 { width: 100px; height: 100px; top: 20%; left: 10%; animation: float1 15s ease-in-out infinite; }
.float-2 { width: 60px; height: 60px; top: 60%; right: 20%; animation: float2 12s ease-in-out infinite; }
.float-3 { width: 80px; height: 80px; bottom: 30%; left: 20%; animation: float3 18s ease-in-out infinite; }
.float-4 { width: 40px; height: 40px; top: 30%; right: 30%; animation: float4 10s ease-in-out infinite; }

.hero-glass-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 30px;
    padding: 40px 60px;
    text-align: center;
    box-shadow: var(--shadow-light);
    position: relative;
    z-index: 10;
    max-width: 800px;
    margin: 0 20px;
}

.hero-title {
    margin-bottom: 20px;
    position: relative;
}

.title-text {
    font-size: 3.5rem;
    font-weight: 800;
    color: white;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    display: block;
    background: linear-gradient(45deg, #fff, #f0f0f0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.title-underline {
    width: 100px;
    height: 4px;
    background: var(--accent-gradient);
    border-radius: 2px;
    margin: 20px auto 0;
    animation: expand 2s ease-out;
}

.hero-subtitle {
    font-size: 1.3rem;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 400;
    margin-bottom: 30px;
    line-height: 1.6;
}

.hero-decoration {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-border);
    animation: pulse 3s ease-in-out infinite;
}

.hero-decoration i {
    font-size: 2rem;
    color: rgba(255, 255, 255, 0.9);
}

.hero-scroll-indicator {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 10;
}

.scroll-arrow {
    width: 30px;
    height: 30px;
    border-right: 2px solid rgba(255, 255, 255, 0.7);
    border-bottom: 2px solid rgba(255, 255, 255, 0.7);
    transform: rotate(45deg);
    animation: bounce 2s ease-in-out infinite;
}

/* Alert */
.custom-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 15px;
    box-shadow: var(--shadow-light);
    animation: slideInRight 0.5s ease;
}

.alert-content {
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.alert-icon i {
    font-size: 1.5rem;
    color: #10b981;
}

.alert-text {
    color: white;
    font-weight: 500;
    flex: 1;
}

.alert-dismiss {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    padding: 5px;
    border-radius: 50%;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.alert-dismiss:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

/* Posts Container */
.posts-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 60px 20px;
    position: relative;
    z-index: 5;
}

/* Posts Grid */
.posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
    gap: 40px;
    margin-bottom: 80px;
}

/* Poetry Cards */
.poetry-card {
    position: relative;
    border-radius: var(--border-radius);
    overflow: hidden;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    transition: var(--transition);
    cursor: pointer;
    display: flex;
    flex-direction: column;
}

.poetry-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: var(--shadow-medium);
}

.card-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(79, 172, 254, 0.1), rgba(0, 242, 254, 0.1));
    opacity: 0;
    transition: var(--transition);
}

.poetry-card:hover .card-background {
    opacity: 1;
}

.card-content {
    padding: 30px;
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 20px;
}

.card-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #3D1E6D;
    margin: 0;
    line-height: 1.4;
    flex: 1;
}

.card-bookmark {
    color: #AAAAAA;
    font-size: 1.2rem;
    cursor: pointer;
    transition: var(--transition);
    padding: 8px;
    border-radius: 8px;
}

.card-bookmark:hover {
    color: #fbbf24;
    background: rgba(251, 191, 36, 0.1);
}

.card-body {
    margin-bottom: 25px;
    flex-grow: 1;
}

.card-excerpt {
    color: #333333;
    line-height: 1.7;
    margin: 0;
    font-size: 0.95rem;
}

.card-meta {
    margin-bottom: 25px;
    padding: 20px 0;
    border-top: 1px solid #e5e7eb;
    border-bottom: 1px solid #e5e7eb;
}

.meta-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.author-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.author-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.2);
}

.author-avatar i {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.8);
}

.author-details {
    display: flex;
    flex-direction: column;
}

.author-name {
    font-weight: 600;
    color: #555555;
    font-size: 0.9rem;
}

.publish-date {
    font-size: 0.8rem;
    color: #777777;
}

.category-tag {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: white;
}

.شعر-کلاسیک-tag { background: linear-gradient(135deg, #ec4899, #be185d); }
.شعر-معاصر-tag { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.داستان-کوتاه-tag { background: linear-gradient(135deg, #06b6d4, #0891b2); }
.دلنوشته-tag { background: linear-gradient(135deg, #f59e0b, #d97706); }

.card-stats {
    display: flex;
    gap: 20px;
}

.stat {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    color: #555555;
}

.stat i {
    color: #7e4bb9;
}

.card-actions {
    display: flex;
    gap: 10px;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
}

.action-btn {
    background: var(--accent-gradient);
    color: white;
    padding: 12px 20px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: var(--transition);
    box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
    min-width: 100px;
    height: 40px;
    line-height: 1;
    border: none;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(79, 172, 254, 0.5);
    color: white;
}

.action-btn.danger {
    background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
}

.action-btn.danger:hover {
    background: linear-gradient(135deg, #c53030 0%, #e53e3e 100%);
    box-shadow: 0 8px 25px rgba(229, 62, 62, 0.4);
}

/* Create Section */
.create-section {
    margin-top: 60px;
}

.create-glass-card {
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: var(--border-radius);
    padding: 50px;
    text-align: center;
    box-shadow: var(--shadow-light);
    position: relative;
    overflow: hidden;
}

.create-content {
    position: relative;
    z-index: 2;
}

.create-icon {
    margin-bottom: 20px;
}

.create-icon i {
    font-size: 3rem;
    color: rgba(255, 255, 255, 0.9);
}

.create-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
    margin: 0 0 15px 0;
}

.create-text {
    color: rgba(255, 255, 255, 0.8);
    font-size: 1.1rem;
    margin: 0 0 30px 0;
    line-height: 1.6;
}

.create-btn {
    background: var(--accent-gradient);
    color: white;
    padding: 16px 32px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    font-size: 1.1rem;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: var(--transition);
    box-shadow: var(--shadow-medium);
}

.create-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
    color: white;
}

.create-decoration {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}

.deco-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(5px);
}

.deco-1 { width: 60px; height: 60px; top: 10%; left: 10%; animation: float1 12s ease-in-out infinite; }
.deco-2 { width: 40px; height: 40px; bottom: 15%; right: 15%; animation: float2 15s ease-in-out infinite; }
.deco-3 { width: 80px; height: 80px; top: 50%; left: 50%; animation: float3 18s ease-in-out infinite; }

/* Empty State */
.empty-content {
    grid-column: 1 / -1;
    text-align: center;
    padding: 100px 20px;
    background: var(--glass-bg);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-light);
}

.empty-icon i {
    font-size: 5rem;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 25px;
}

.empty-title {
    font-size: 1.8rem;
    color: white;
    margin: 0 0 15px 0;
    font-weight: 600;
}

.empty-text {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
    line-height: 1.6;
}

/* Pagination */
.pagination-section {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}

.pagination .page-link {
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    color: white;
    transition: var(--transition);
}

.pagination .page-link:hover {
    background: var(--accent-gradient);
    color: white;
    border-color: transparent;
}

.pagination .page-item.active .page-link {
    background: var(--accent-gradient);
    border-color: transparent;
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes float1 {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(10px, -10px); }
}

@keyframes float2 {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(-10px, 10px); }
}

@keyframes float3 {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(10px, 10px); }
}

@keyframes float4 {
    0%, 100% { transform: translate(0, 0); }
    50% { transform: translate(-10px, -10px); }
}

@keyframes expand {
    0% { width: 0; }
    100% { width: 100px; }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

@keyframes slideInRight {
    0% { opacity: 0; transform: translateX(20px); }
    100% { opacity: 1; transform: translateX(0); }
}

@keyframes bounce {
    0%, 100% { transform: translateY(0) rotate(45deg); }
    50% { transform: translateY(10px) rotate(45deg); }
}

/* Responsive Design */
@media (max-width: 1024px) {
    .posts-grid {
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 25px;
    }
    
    .create-glass-card {
        padding: 40px 30px;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.1rem;
    }
    
    .posts-container {
        padding: 0 15px 40px;
    }
    
    .posts-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .card-content {
        padding: 25px 20px;
    }
    
    .create-glass-card {
        padding: 30px 20px;
    }
    
    .custom-alert {
        margin: 15px;
        padding: 15px 20px;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .page-hero {
        padding: 60px 0 80px;
    }
    
    .card-header {
        flex-direction: column;
        align-items: stretch;
        gap: 15px;
    }
    
    .card-bookmark {
        margin: 0 auto;
    }
    
    .meta-row {
        flex-direction: column;
        gap: 10px;
        align-items: stretch;
    }
    
    .card-stats {
        justify-content: center;
    }
    
    .card-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide success alert after 5 seconds
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.opacity = '0';
            setTimeout(() => {
                successAlert.style.display = 'none';
            }, 300);
        }, 5000);
    }
    
    // Card click functionality
    const poetryCards = document.querySelectorAll('.poetry-card');
    poetryCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.closest('.action-btn')) {
                const readBtn = this.querySelector('.action-btn.primary');
                if (readBtn) {
                    readBtn.click();
                }
            }
        });
    });
});

function hideAlert() {
    const alert = document.getElementById('successAlert');
    if (alert) {
        alert.style.opacity = '0';
        setTimeout(() => {
            alert.style.display = 'none';
        }, 300);
    }
}
</script>
@endsection
```