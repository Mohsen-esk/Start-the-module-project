```blade
@extends('layouts.app')

@section('title', 'پروفایل کاربری - Note Me')

@section('content')
<style>
.profile-container {
    background: linear-gradient(135deg, #e0eafc, #cfdef3);
    min-height: 100vh;
    padding: 2rem 1rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    direction: rtl;
}

.profile-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 0 auto;
    position: relative;
}

.profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.profile-header {
    text-align: right;
    margin-bottom: 2rem;
}

.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin: 0 auto 1rem;
    position: relative;
    overflow: hidden;
    border: 3px solid white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-header h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.back-btn {
    display: inline-block;
    background: #6c757d;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    text-decoration: none;
    margin-bottom: 2rem;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background: #5a6268;
    color: white;
    text-decoration: none;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
    background: white;
    transition: all 0.3s ease;
    direction: rtl;
    text-align: right;
}

.form-control[type="email"] {
    direction: ltr;
    text-align: left;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    text-align:	location: right;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
}

.btn-primary:disabled {
    opacity: 0.7;
    transform: none;
}

.alert {
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    text-align: right;
}

.alert-success {
    background: #d1edff;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.password-section {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e9ecef;
}

.password-section h4 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.1rem;
    text-align: right;
}

@media (max-width: 768px) {
    .profile-container {
        padding: 1rem 0.5rem;
    }
    
    .profile-card {
        padding: 1.5rem;
    }
}
</style>

<div class="profile-container">
    <!-- Back Button -->
    <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        بازگشت به داشبورد
    </a>

    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Profile Card -->
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-avatar">
                <img src="{{ $user->avatar }}" alt="Avatar">
            </div>
            <h1>ویرایش پروفایل</h1>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="avatar" class="form-label">عکس پروفایل (اختیاری)</label>
                <input type="file"
                       class="form-control @error('avatar') is-invalid @enderror"
                       id="avatar"
                       name="avatar">
                @error('avatar')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="full_name" class="form-label">نام کامل</label>
                <input type="text" 
                       class="form-control @error('full_name') is-invalid @enderror" 
                       id="full_name" 
                       name="full_name" 
                       value="{{ old('full_name', $user->name) }}" 
                       required>
                @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nickname" class="form-label">نام مستعار (اختیاری)</label>
                <input type="text" 
                       class="form-control @error('nickname') is-invalid @enderror" 
                       id="nickname" 
                       name="nickname" 
                       value="{{ old('nickname', $user->nickname ?? '') }}" 
                       placeholder="نام مستعار خود را وارد کنید">
                @error('nickname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">ایمیل</label>
                <input type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $user->email) }}" 
                       required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">شماره موبایل (اختیاری)</label>
                <input type="text" 
                       class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" 
                       name="phone" 
                       value="{{ old('phone', $user->phone ?? '') }}" 
                       placeholder="09xxxxxxxxx">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="work_field" class="form-label">زمینه کاری (اختیاری)</label>
                <input type="text" 
                       class="form-control @error('work_field') is-invalid @enderror" 
                       id="work_field" 
                       name="work_field" 
                       value="{{ old('work_field', $user->work_field ?? '') }}" 
                       placeholder="زمینه کاری خود را وارد کنید">
                @error('work_field')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="password-section">
                <h4>تغییر رمز عبور (اختیاری)</h4>
                
                <div class="form-group">
                    <label for="password" class="form-label">رمز عبور جدید</label>
                    <input type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password"
                           placeholder="اگر نمی‌خواهید تغییر دهید خالی بگذارید">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">تأیید رمز عبور جدید</label>
                    <input type="password" 
                           class="form-control" 
                           id="password_confirmation" 
                           name="password_confirmation">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i>
                ذخیره تغییرات
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('.btn-primary');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> در حال ذخیره...';
            submitBtn.disabled = true;
        });
    }

    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });
});
</script>
@endsection
```