@extends('layouts.app')

@section('title', 'داشبورد - Note Me')

@section('content')
<!-- Bootstrap CSS برای این صفحه -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* استایل‌های مخصوص داشبورد */
.dashboard-wrapper {
    background: #f8f9fa;
    font-family: 'Tahoma', sans-serif;
    min-height: 100vh;
    padding: 0;
    margin: 0;
}

.sidebar {
    background: linear-gradient(180deg, #9327a8 0%, #b27dca 100%);
    min-height: 100vh;
    color: white;
    padding: 0;
}

.sidebar .sidebar-content {
    padding: 20px;
}

.sidebar h4 {
    text-align: center;
    margin-bottom: 30px;
    color: white;
}

.sidebar .nav-link {
    color: rgba(255, 255, 255, 0.8);
    padding: 15px 20px;
    border-radius: 8px;
    margin: 5px 0;
    transition: all 0.3s ease;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.sidebar .nav-link:hover, 
.sidebar .nav-link.active {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    transform: translateX(-5px);
}

.sidebar .nav-link i {
    margin-left: 10px;
    width: 20px;
}

.sidebar hr {
    border-color: rgba(255, 255, 255, 0.3);
    margin: 20px 0;
}

.sidebar .logout-btn {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    padding: 15px 20px;
    border-radius: 8px;
    margin: 5px 0;
    transition: all 0.3s ease;
    width: 100%;
    text-align: right;
    display: flex;
    align-items: center;
}

.sidebar .logout-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    transform: translateX(-5px);
}

.sidebar .logout-btn i {
    margin-left: 10px;
    width: 20px;
}

.main-content {
    padding: 30px;
    background: #f8f9fa;
}

.stats-card {
    background: white;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(161, 171, 185, 0.08);
    border: none;
    margin-bottom: 20px;
    transition: transform 0.3s ease;
    cursor: pointer;
}

.stats-card:hover {
    transform: translateY(-5px);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-bottom: 15px;
}

.welcome-card {
    background: linear-gradient(135deg, #882096 0%, #c280d3 100%);
    color: white;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 30px;
}

.btn-custom {
    background: linear-gradient(135deg, #882096 0%, #c280d3 100%);
    border: none;
    border-radius: 25px;
    padding: 10px 25px;
    color: rgb(255, 255, 255);
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    background: linear-gradient(135deg, #b128cc 0%, #d78ada 100%);
    color: rgb(255, 255, 255);
    text-decoration: none;
    transform: translateY(-2px);
}

.dashboard-alert {
    border-radius: 10px;
    margin-bottom: 20px;
}

.activity-list .list-group-item {
    border: none;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
    background: transparent;
}

.activity-list .list-group-item:last-child {
    border-bottom: none;
}

.badge {
    font-size: 0.8em;
}

/* موبایل */
@media (max-width: 768px) {
    .main-content {
        padding: 20px 15px;
    }
    
    .stats-card {
        padding: 20px 15px;
        margin-bottom: 15px;
    }
    
    .welcome-card {
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .welcome-card h2 {
        font-size: 1.5rem;
    }
}
</style>

<div class="dashboard-wrapper">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2">
                <div class="sidebar">
                    <div class="sidebar-content">
                        <h3>داشبورد من</h3>
                        <nav class="nav flex-column">
                            <a class="nav-link active" href="{{ route('dashboard') }}">
                                <i class="bi bi-house-door"></i>
                                خانه
                            </a>
                            <a class="nav-link" href="{{ route('profile') }}">
                                <i class="bi bi-person"></i>
                                پروفایل
                            </a>
                            <a class="nav-link" href="{{ route('posts.index') }}">
                                <i class="bi bi-file-text"></i>
                                مطالب من
                            </a>
                            <a class="nav-link" href="{{ route('dashboard.saved') }}">
                                <i class="bi bi-bookmark"></i>
                                پست‌های ذخیره شده
                            </a>
                            <a class="nav-link" href="#">
                                <i class="bi bi-gear"></i>
                                تنظیمات
                            </a>
                            <hr>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="logout-btn">
                                    <i class="bi bi-box-arrow-right"></i>
                                    خروج
                                </button>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show dashboard-alert" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Welcome Card -->
                    <div class="welcome-card">
                        <div class="row align-items-center">
                            <div class="col-md-8 text-end">
                                <h2>خوش آمدید، {{ $user->name }}!</h2>
                                <p class="mb-3">امروز روز خوبی برای شروع کار جدید است.</p>
                                <a href="{{ route('profile') }}" class="btn btn-light btn-sm">
                                    ویرایش پروفایل
                                </a>
                            </div>
                            <div class="col-md-4 text-center">
                                <i class="bi bi-person-circle" style="font-size: 80px; opacity: 0.3;"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('posts.published') }}" class="text-decoration-none">
                                <div class="stats-card text-center">
                                    <div class="stats-icon bg-primary bg-opacity-10 mx-auto">
                                        <i class="bi bi-file-text text-primary"></i>
                                    </div>
                                    <h3 class="text-primary">{{ $published_posts_count }}</h3>
                                    <p class="text-muted mb-0">نوشته‌های منتشر شده</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('posts.index') }}" class="text-decoration-none">
                                <div class="stats-card text-center">
                                    <div class="stats-icon bg-success bg-opacity-10 mx-auto">
                                        <i class="bi bi-journal-text text-success"></i>
                                    </div>
                                    <h3 class="text-success">{{ $posts_count }}</h3>
                                    <p class="text-muted mb-0">نوشته تازه</p>
                                    <a href="{{ route('posts.create') }}" class="btn-custom btn-sm mt-3">اضافه کردن نوشته</a>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('posts.views') }}" class="text-decoration-none">
                                <div class="stats-card text-center">
                                    <div class="stats-icon bg-warning bg-opacity-10 mx-auto">
                                        <i class="bi bi-eye text-warning"></i>
                                    </div>
                                    <h3 class="text-warning">{{ $total_views }}</h3>
                                    <p class="text-muted mb-0">بازدید</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('posts.likes') }}" class="text-decoration-none">
                                <div class="stats-card text-center">
                                    <div class="stats-icon bg-info bg-opacity-10 mx-auto">
                                        <i class="bi bi-heart text-info"></i>
                                    </div>
                                    <h3 class="text-info">{{ $total_likes }}</h3>
                                    <p class="text-muted mb-0">لایک</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <div class="stats-card">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5>فعالیت‌های اخیر</h5>
                                    <a href="{{ route('posts.all') }}" class="btn-custom btn-sm">مشاهده همه</a>
                                </div>
                                <div class="activity-list">
                                    <div class="list-group list-group-flush">
                                        @forelse ($recent_posts as $post)
                                            <div class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="me-auto">
                                                    <div class="fw-bold">{{ $post->title }}</div>
                                                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                                </div>
                                                <span class="badge bg-primary rounded-pill">جدید</span>
                                            </div>
                                        @empty
                                            <div class="list-group-item">
                                                <div class="text-muted">فعالیتی وجود ندارد</div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card">
                                <h5 class="mb-3">اطلاعات سریع</h5>
                                <div class="mb-3">
                                    <small class="text-muted">نام کامل:</small>
                                    <br><strong>{{ $user->name }}</strong>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">نام مستعار:</small>
                                    <br><strong>{{ $user->nickname ?? 'وارد نشده' }}</strong>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">ایمیل:</small>
                                    <br><strong>{{ $user->email }}</strong>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted">تلفن:</small>
                                    <br><strong>{{ $user->phone ?? 'وارد نشده' }}</strong>
                                </div>
                                @if($user->work_field)
                                    <div class="mb-3">
                                        <small class="text-muted">زمینه کاری:</small>
                                        <br><strong>{{ $user->work_field }}</strong>
                                    </div>
                                @endif
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
@endsection