@extends('layouts.app')

@section('title', $post->title . ' - Note Me')

@section('content')
<div class="post-page">
    <div class="post-hero">
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
                    <span class="breadcrumb-current">{{ Str::limit($post->title, 30) }}</span>
                </nav>
            </div>
        </div>
    </div>

    <div class="post-wrapper">
        <div class="container">
            <div class="post-grid">
                <article class="post-main">
                    <header class="post-header-section">
                        <div class="post-category-badge">
                            <i class="fas fa-bookmark"></i>
                            {{ $post->category->name ?? 'بدون دسته' }}
                        </div>
                        <h1 class="post-main-title">{{ $post->title }}</h1>
                        
                        <div class="post-author-card">
                            <div class="author-avatar">
                                <img src="{{ $post->user->avatar }}" alt="{{ $post->user->nickname ?? $post->user->name ?? 'ناشناس' }}" class="avatar-img">
                            </div>
                            <div class="author-info">
                                <div class="author-name">{{ $post->user->nickname ?? $post->user->name ?? 'ناشناس' }}</div>
                                <div class="author-meta">
                                    <span class="publish-date">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $post->created_at->format('d F Y') }}
                                    </span>
                                    @if($post->created_at != $post->updated_at)
                                    <span class="update-date">
                                        <i class="fas fa-edit"></i>
                                        آخرین ویرایش: {{ $post->updated_at->format('d F Y') }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </header>

                    @if ($post->featured_image)
                        <div class="post-featured-image">
                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="img-fluid">
                        </div>
                    @endif

                    <div class="post-content-section">
                        <div class="content-wrapper">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                    </div>

                    {{-- Comments Section --}}
                    <div class="post-comments-section">
                        <h2 class="section-title">نظرات ({{ $post->comments->count() }})</h2>

                        @auth
                            <div class="comment-form-wrapper">
                                <form action="{{ route('posts.comments.store', $post) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="comment-content">نظر خود را بنویسید</label>
                                        <textarea name="content" id="comment-content" rows="4" placeholder="نظر شما..." required></textarea>
                                        @error('content')
                                            <p class="error-message">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i>
                                        ارسال نظر
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="login-prompt">
                                <p>برای ثبت نظر، لطفاً <a href="{{ route('login') }}">وارد شوید</a> یا <a href="{{ route('register') }}">ثبت‌نام کنید</a>.</p>
                            </div>
                        @endauth

                        <div class="comments-list">
                            @forelse ($post->comments as $comment)
                                <div class="comment-item">
                                    <div class="comment-author-avatar">
                                        <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}">
                                    </div>
                                    <div class="comment-body">
                                        <div class="comment-header">
                                            <span class="comment-author-name">{{ $comment->user->name }}</span>
                                            <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="comment-content">
                                            <p>{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="no-comments">
                                    <p>هنوز نظری ثبت نشده است. اولین نفر باشید!</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <footer class="post-footer-section">
                        <div class="post-engagement">
                            <div class="engagement-stats">
                                <div class="stat-item">
                                    <i class="fas fa-eye"></i>
                                    <span>{{ $post->views_count ?? 0 }}</span>
                                    <span>بازدید</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-heart"></i>
                                    <span>{{ is_countable($post->likes) ? $post->likes->count() : 0 }}</span>
                                    <span>لایک</span>
                                </div>
                                <div class="stat-item">
                                    <i class="fas fa-comment"></i>
                                    <span>{{ $post->comments->count() }}</span>
                                    <span>نظر</span>
                                </div>
                            </div>
                        </div>

                        <div class="post-actions-section">
                            <div class="action-buttons">
                                <a href="{{ route('posts.index') }}" class="btn btn-outline">
                                    <i class="fas fa-arrow-right"></i>
                                    بازگشت به لیست
                                </a>
                                
                                @auth
                                    <form action="{{ route('posts.like', $post) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-like {{ Auth::user()->likedPosts->contains($post) ? 'liked' : '' }}">
                                            @if(Auth::user()->likedPosts->contains($post))
                                                <i class="fas fa-heart"></i>
                                                <span>لایک شده</span>
                                            @else
                                                <i class="far fa-heart"></i>
                                                <span>لایک</span>
                                            @endif
                                        </button>
                                    </form>
                                    <form action="{{ route('posts.save', $post) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-info">
                                            @if(Auth::user()->savedPosts->contains($post))
                                                <i class="bi bi-bookmark-fill"></i>
                                                <span>ذخیره شده</span>
                                            @else
                                                <i class="bi bi-bookmark"></i>
                                                <span>ذخیره</span>
                                            @endif
                                        </button>
                                    </form>
                                    @if (Auth::id() === $post->user_id)
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit"></i>
                                            ویرایش پست
                                        </a>
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $post->id }})">
                                            <i class="fas fa-trash-alt"></i>
                                            حذف پست
                                        </button>
                                    @endif
                                @endauth
                            </div>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal-overlay" id="deleteModal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3><i class="fas fa-exclamation-triangle"></i> تأیید حذف</h3>
                                </div>
                                <div class="modal-body">
                                    <p>آیا مطمئن هستید که می‌خواهید این پست را حذف کنید؟</p>
                                    <p class="warning-text">این عمل قابل بازگشت نیست!</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline" onclick="closeDeleteModal()">
                                        <i class="fas fa-times"></i>
                                        انصراف
                                    </button>
                                    <form id="deleteForm" method="POST" action="{{ route('posts.destroy', $post->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                            تأیید حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </footer>
                </article>

                <aside class="post-sidebar">
                    <div class="sidebar-widget author-widget">
                        <div class="widget-header">
                            <h3>نویسنده</h3>
                        </div>
                        <div class="widget-content">
                            <div class="author-profile">
                                <div class="author-avatar-large">
                                    <img src="{{ $post->user->avatar }}" alt="{{ $post->user->nickname ?? $post->user->name ?? 'ناشناس' }}" class="avatar-img-large">
                                </div>
                                <div class="author-details">
                                    <h4>{{ $post->user->nickname ?? $post->user->name ?? 'ناشناس' }}</h4>
                                    <p>نویسنده و خالق محتوا</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-widget share-widget">
                        <div class="widget-header">
                            <h3>اشتراک‌گذاری</h3>
                        </div>
                        <div class="widget-content">
                            <div class="share-buttons">
                                <a href="#" class="share-btn telegram">
                                    <i class="fab fa-telegram"></i>
                                    تلگرام
                                </a>
                                <a href="#" class="share-btn twitter">
                                    <i class="fab fa-twitter"></i>
                                    توییتر
                                </a>
                                <a href="#" class="share-btn linkedin">
                                    <i class="fab fa-linkedin"></i>
                                    لینکدین
                                </a>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>

<style>
/* Base Styles */
.post-page {
    background: #f8fafc;
    min-height: calc(100vh - 80px);
    direction: rtl;
}

/* Hero Section */
.post-hero {
    position: relative;
    background: linear-gradient(135deg, #833792 0%, #8338a0 100%);
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

/* Post Wrapper */
.post-wrapper {
    padding: 40px 0;
}

.post-grid {
    display: grid;
    grid-template-columns: 1fr 300px;
    gap: 40px;
    align-items: start;
}

.post-main {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgb(119, 35, 112);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.post-header-section {
    padding: 40px 40px 30px;
    background: linear-gradient(135deg, #7a1883 0%, #e2e8f0 100%);
    border-bottom: 1px solid #ff92ff;
}

.post-category-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: linear-gradient(135deg, #d864e7 0%, #db2dd3 100%);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 20px;
}

.post-main-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a202c;
    line-height: 1.2;
    margin-bottom: 30px;
    word-wrap: break-word;
}

.post-author-card {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px;
    background: white;
    border-radius: 15px;
    border: 1px solid #e2e8f0;
}

.author-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.author-info {
    flex: 1;
}

.author-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 5px;
}

.author-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    font-size: 0.85rem;
    color: #718096;
}

.author-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.post-featured-image {
    padding: 0 40px;
    margin-bottom: 30px;
    text-align: center;
}

.img-fluid {
    max-width: 100%;
    height: auto;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.post-content-section {
    padding: 40px;
    padding-bottom: 0;
}

.content-wrapper {
    font-size: 1.125rem;
    line-height: 1.8;
    color: #2d3748;
    word-wrap: break-word;
}

.content-wrapper p {
    margin-bottom: 1.5rem;
}

/* Comments Section */
.post-comments-section {
    padding: 40px;
    margin-top: 20px;
    background-color: #ffffff;
    border-top: 1px solid #e2e8f0;
}

.section-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2d3748;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #e369f3;
    display: inline-block;
}

.comment-form-wrapper {
    margin-bottom: 40px;
    background: #f8fafc;
    padding: 25px;
    border-radius: 15px;
    border: 1px solid #e2e8f0;
}

.comment-form-wrapper .form-group {
    margin-bottom: 20px;
}

.comment-form-wrapper label {
    display: block;
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 10px;
}

.comment-form-wrapper textarea {
    width: 100%;
    padding: 12px 15px;
    border-radius: 10px;
    border: 1px solid #cbd5e0;
    font-family: inherit;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.comment-form-wrapper textarea:focus {
    outline: none;
    border-color: #9334af;
    box-shadow: 0 0 0 3px rgba(147, 52, 175, 0.2);
}

.error-message {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 5px;
}

.login-prompt {
    text-align: center;
    padding: 20px;
    background: #f8fafc;
    border-radius: 15px;
    margin-bottom: 40px;
    border: 1px solid #e2e8f0;
}

.login-prompt a {
    color: #9334af;
    font-weight: 600;
    text-decoration: none;
}
.login-prompt a:hover {
    text-decoration: underline;
}

.comments-list .comment-item {
    display: flex;
    gap: 15px;
    padding: 20px 0;
    border-bottom: 1px solid #e2e8f0;
}
.comments-list .comment-item:last-child {
    border-bottom: none;
}

.comment-author-avatar img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
}

.comment-body {
    flex: 1;
}

.comment-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.comment-author-name {
    font-weight: 600;
    color: #2d3748;
}

.comment-date {
    font-size: 0.8rem;
    color: #718096;
}

.comment-content p {
    margin: 0;
    color: #4a5568;
    line-height: 1.7;
}

.no-comments {
    text-align: center;
    padding: 30px;
    color: #718096;
}

.post-footer-section {
    padding: 30px 40px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
}

.post-engagement {
    margin-bottom: 30px;
}

.engagement-stats {
    display: flex;
    gap: 30px;
    justify-content: center;
    padding: 20px;
    background: white;
    border-radius: 15px;
    border: 1px solid #ffb3f9;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    text-align: center;
}

.stat-item i {
    font-size: 1.5rem;
    color: #db39db;
}

.stat-item span:first-of-type {
    font-size: 1.5rem;
    font-weight: 700;
    color: #e369f3;
}

.stat-item span:last-of-type {
    font-size: 0.85rem;
    color: #718096;
    font-weight: 500;
}

.action-buttons {
    display: flex;
    gap: 15px;
    justify-content: center;
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
}

.btn-primary {
    background: linear-gradient(135deg, #e064ff 0%, #9334af 100%);
    color: rgb(255, 255, 255);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    color: white;
    text-decoration: none;
}

.btn-outline {
    background: white;
    color: #c04fc0;
    border: 2px solid #e274ca;
}

.btn-outline:hover {
    background: #667eea;
    color: white;
    text-decoration: none;
    transform: translateY(-2px);
}

.btn-danger {
    background: linear-gradient(135deg, #ac26ce 0%, #d87beb 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(229, 62, 62, 0.3);
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(229, 62, 62, 0.4);
    color: white;
    text-decoration: none;
    background: linear-gradient(135deg, #c53030 0%, #e53e3e 100%);
}

.btn-like {
    background: white;
    color: #ef4444;
    border: 2px solid #ef4444;
}

.btn-like.liked,
.btn-like:hover {
    background: #ef4444;
    color: white;
    text-decoration: none;
}

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    opacity: 0;
    transition: all 0.3s ease;
}

.modal-overlay.show {
    display: flex;
    opacity: 1;
}

.modal-content {
    background: white;
    border-radius: 20px;
    max-width: 500px;
    width: 90%;
    margin: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    transform: scale(0.8);
    transition: all 0.3s ease;
    overflow: hidden;
}

.modal-overlay.show .modal-content {
    transform: scale(1);
}

.modal-header {
    padding: 25px 30px 20px;
    background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
    border-bottom: 1px solid #fed7d7;
}

.modal-header h3 {
    margin: 0;
    color: #c53030;
    font-size: 1.3rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.modal-header i {
    font-size: 1.5rem;
    color: #e53e3e;
}

.modal-body {
    padding: 30px;
    text-align: center;
}

.modal-body p {
    margin: 0 0 15px;
    font-size: 1.1rem;
    color: #2d3748;
    line-height: 1.6;
}

.warning-text {
    color: #e53e3e !important;
    font-weight: 600;
    font-size: 1rem !important;
}

.modal-footer {
    padding: 20px 30px 30px;
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.modal-footer .btn {
    min-width: 120px;
}

.post-sidebar {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.sidebar-widget {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgb(237, 44, 255);
    border: 1px solid rgb(250, 177, 246);
}

.widget-header {
    padding: 20px 25px;
    background: linear-gradient(135deg, #b148be 0%, #e2e8f0 100%);
    border-bottom: 1px solid #e2e8f0;
}

.widget-header h3 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
}

.widget-content {
    padding: 25px;
}

.author-profile {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 15px;
}

.author-avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.author-avatar-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.author-details h4 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #a5388a;
    margin: 0 0 5px;
}

.author-details p {
    font-size: 0.9rem;
    color: #718096;
    margin: 0;
}

.share-buttons {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.share-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.share-btn.telegram {
    background: #f06df5;
    color: white;
}

.share-btn.twitter {
    background: #f06df5;
    color: white;
}

.share-btn.linkedin {
    background: #f06df5;
    color: white;
}

.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    text-decoration: none;
    color: white;
}

@media (max-width: 1024px) {
    .post-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .post-sidebar {
        order: -1;
    }
}

@media (max-width: 768px) {
    .post-hero {
        padding: 40px 0 20px;
    }
    
    .post-wrapper {
        padding: 20px 0;
    }
    
    .container {
        padding: 0 15px;
    }
    
    .post-header-section,
    .post-content-section,
    .post-footer-section {
        padding: 25px 20px;
    }
    
    .post-main-title {
        font-size: 2rem;
    }
    
    .post-author-card {
        padding: 15px;
    }
    
    .engagement-stats {
        gap: 20px;
        padding: 15px;
    }
    
    .stat-item i {
        font-size: 1.2rem;
    }
    
    .stat-item span:first-of-type {
        font-size: 1.2rem;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
        max-width: 200px;
    }
    
    .breadcrumb-nav {
        flex-wrap: wrap;
    }
}

@media (max-width: 480px) {
    .post-main-title {
        font-size: 1.8rem;
    }
    
    .engagement-stats {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .author-meta {
        flex-direction: column;
        gap: 8px;
    }
}
</style>

@section('scripts')
<script>
function confirmDelete(postId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = '{{ route("posts.destroy", "' + postId + '") }}';
    modal.classList.add('show');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.remove('show');
}
</script>
@endsection
@endsection