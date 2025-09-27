@extends('layouts.app')

@section('title', 'ثبت نام - Note Me')

@section('content')
<style>
.register-container {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: #f3f4f6;
    min-height: calc(100vh - 80px - 200px);
    direction: rtl;
}

.register-card {
    background: #ffffff;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    border: 1px solid #e5e7eb;
}

.register-header {
    text-align: right;
    margin-bottom: 1.5rem;
}

.register-header h1 {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.register-header p {
    font-size: 0.9rem;
    color: #6b7280;
}

.register-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.register-form-group {
    display: flex;
    flex-direction: column;
}

.register-form-group label {
    font-size: 0.9rem;
    font-weight: 500;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.register-form-control {
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 0.95rem;
    background: #ffffff;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    direction: rtl;
    text-align: right;
}

.register-form-control:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.register-form-control.is-invalid {
    border-color: #dc2626;
}

.register-password-wrapper {
    position: relative;
}

.register-password-toggle {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    font-size: 0.9rem;
    cursor: pointer;
    z-index: 10;
}

.register-password-toggle:hover {
    color: #2563eb;
}

.register-invalid-feedback {
    font-size: 0.8rem;
    color: #dc2626;
    margin-top: 0.25rem;
    text-align: right;
}

.register-btn-primary {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: #ffffff;
    padding: 0.75rem;
    border: none;
    border-radius: 6px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.2);
}

.register-btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.register-auth-links {
    text-align: right;
    margin-top: 1rem;
    font-size: 0.9rem;
    color: #6b7280;
}

.register-auth-links a {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.register-auth-links a:hover {
    color: #1d4ed8;
    text-decoration: underline;
}

input[type="text"],
input[type="email"],
input[type="password"],
textarea {
    direction: rtl;
    text-align: right;
}

input[type="email"] {
    direction: ltr;
    text-align: left;
}

@media (max-width: 480px) {
    .register-container {
        padding: 1rem;
    }
    
    .register-card {
        padding: 1.5rem;
        max-width: 95%;
    }

    .register-header h1 {
        font-size: 1.5rem;
    }

    .register-form-control {
        padding: 0.65rem;
        font-size: 0.9rem;
    }

    .register-btn-primary {
        padding: 0.65rem;
        font-size: 0.9rem;
    }
}
</style>

<div class="register-container">
    <div class="register-card">
        <div class="register-header">
            <h1>ثبت نام</h1>
            <p>حساب کاربری جدید بسازید</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="register-form">
            @csrf

            <div class="register-form-group">
                <label for="name">نام کامل</label>
                <input type="text" id="name" name="full_name" value="{{ old('full_name') }}"
                       class="register-form-control @error('full_name') is-invalid @enderror"
                       placeholder="نام و نام خانوادگی"
                       required autofocus>
                @error('full_name')
                    <span class="register-invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="register-form-group">
                <label for="nickname">نام مستعار (اختیاری)</label>
                <input type="text" id="nickname" name="nickname" value="{{ old('nickname') }}"
                       class="register-form-control @error('nickname') is-invalid @enderror"
                       placeholder="نام مستعار خود را وارد کنید">
                @error('nickname')
                    <span class="register-invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="register-form-group">
                <label for="email">ایمیل</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                       class="register-form-control @error('email') is-invalid @enderror"
                       placeholder="example@email.com"
                       required>
                @error('email')
                    <span class="register-invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="register-form-group">
                <label for="phone">شماره موبایل (اختیاری)</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                       class="register-form-control @error('phone') is-invalid @enderror"
                       placeholder="09xxxxxxxxx">
                @error('phone')
                    <span class="register-invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="register-form-group">
                <label for="work_field">زمینه کاری (اختیاری)</label>
                <input type="text" id="work_field" name="work_field" value="{{ old('work_field') }}"
                       class="register-form-control @error('work_field') is-invalid @enderror"
                       placeholder="زمینه کاری خود را وارد کنید">
                @error('work_field')
                    <span class="register-invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="register-form-group">
                <label for="password">رمز عبور</label>
                <div class="register-password-wrapper">
                    <input type="password" id="password" name="password"
                           class="register-form-control @error('password') is-invalid @enderror"
                           placeholder="حداقل ۸ کاراکتر"
                           required>
                    <button type="button" class="register-password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="password-icon"></i>
                    </button>
                </div>
                @error('password')
                    <span class="register-invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="register-form-group">
                <label for="password_confirmation">تأیید رمز عبور</label>
                <div class="register-password-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="register-form-control"
                           placeholder="رمز عبور را دوباره وارد کنید"
                           required>
                    <button type="button" class="register-password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye" id="password_confirmation-icon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="register-btn-primary">
                <i class="fas fa-user-plus"></i>
                ثبت نام
            </button>

            <div class="register-auth-links">
                <p>حساب دارید؟ <a href="{{ route('login') }}">ورود به حساب</a></p>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + '-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const formGroups = document.querySelectorAll('.register-form-group');
    formGroups.forEach((group, index) => {
        group.style.opacity = '0';
        group.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            group.style.transition = 'all 0.5s ease';
            group.style.opacity = '1';
            group.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endsection