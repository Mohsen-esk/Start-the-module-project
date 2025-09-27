{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'ورود - Note Me')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>ورود به Note Me</h1>
            <p>به حساب کاربری خود وارد شوید</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">ایمیل</label>
                <input type="email" id="email" name="email" 
                       value="{{ old('email') }}" 
                       class="form-control @error('email') error @enderror" 
                       required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">رمز عبور</label>
                <div class="password-input">
                    <input type="password" id="password" name="password" 
                           class="form-control @error('password') error @enderror" 
                           required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="password-icon"></i>
                    </button>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label for="remember" class="form-check-label">مرا به خاطر بسپار</label>
            </div>

            <button type="submit" class="btn btn-primary">ورود</button>

            <div class="auth-links">
                <p>حساب کاربری ندارید؟ <a href="{{ route('register') }}">ثبت نام کنید</a></p>
            </div>
        </form>
    </div>
</div>

<style>
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
}

.auth-card {
    background: white;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    width: 100%;
    max-width: 400px;
}

.auth-header {
    text-align: center;
    margin-bottom: 30px;
}

.auth-header h1 {
    color: #2d3748;
    margin-bottom: 10px;
    font-size: 2rem;
}

.auth-header p {
    color: #666;
    margin-bottom: 0;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: #2d3748;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control.error {
    border-color: #e53e3e;
}

.password-input {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    font-size: 1rem;
}

.form-check {
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-check-input {
    width: auto;
}

.btn {
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.auth-links {
    text-align: center;
    margin-top: 25px;
}

.auth-links a {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.auth-links a:hover {
    text-decoration: underline;
}

.error-message {
    color: #e53e3e;
    font-size: 0.9rem;
    margin-top: 5px;
    display: block;
}

@media (max-width: 480px) {
    .auth-card {
        padding: 25px;
    }
}
</style>

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
</script>
@endsection

{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.app')

@section('title', 'ثبت نام - Note Me')

@section('content')
<div class="auth-container">
    <div class="auth-card register-card">
        <div class="auth-header">
            <h1>عضویت در Note Me</h1>
            <p>حساب کاربری جدید ایجاد کنید</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="auth-form" enctype="multipart/form-data">
            @csrf

            <!-- Avatar Upload -->
            <div class="form-group avatar-upload">
                <label for="avatar">تصویر پروفایل (اختیاری)</label>
                <div class="avatar-input-container">
                    <img id="avatar-preview" src="{{ asset('images/default-avatar.png') }}" alt="آواتار">
                    <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar()">
                    <label for="avatar" class="avatar-upload-btn">
                        <i class="fas fa-camera"></i>
                        انتخاب تصویر
                    </label>
                </div>
                @error('avatar')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="name">نام و نام خانوادگی</label>
                    <input type="text" id="name" name="name" 
                           value="{{ old('name') }}" 
                           class="form-control @error('name') error @enderror" 
                           required>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">ایمیل</label>
                    <input type="email" id="email" name="email" 
                           value="{{ old('email') }}" 
                           class="form-control @error('email') error @enderror" 
                           required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">شماره موبایل (اختیاری)</label>
                    <input type="text" id="phone" name="phone" 
                           value="{{ old('phone') }}" 
                           placeholder="09xxxxxxxxx"
                           class="form-control @error('phone') error @enderror">
                    @error('phone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="birth_date">تاریخ تولد (اختیاری)</label>
                    <input type="date" id="birth_date" name="birth_date" 
                           value="{{ old('birth_date') }}" 
                           class="form-control @error('birth_date') error @enderror">
                    @error('birth_date')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="gender">جنسیت (اختیاری)</label>
                <select id="gender" name="gender" class="form-control @error('gender') error @enderror">
                    <option value="">انتخاب کنید</option>
                    <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>مرد</option>
                    <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>زن</option>
                    <option value="other" {{ old('gender') === 'other' ? 'selected' : '' }}>سایر</option>
                </select>
                @error('gender')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="bio">بیوگرافی (اختیاری)</label>
                <textarea id="bio" name="bio" rows="3" 
                          placeholder="درباره خود بنویسید..."
                          class="form-control @error('bio') error @enderror">{{ old('bio') }}</textarea>
                @error('bio')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">رمز عبور</label>
                    <div class="password-input">
                        <input type="password" id="password" name="password" 
                               class="form-control @error('password') error @enderror" 
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="password-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">تایید رمز عبور</label>
                    <div class="password-input">
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               class="form-control" 
                               required>
                        <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="password_confirmation-icon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">ثبت نام</button>

            <div class="auth-links">
                <p>قبلا ثبت نام کرده‌اید؟ <a href="{{ route('login') }}">وارد شوید</a></p>
            </div>
        </form>
    </div>
</div>

<style>
.register-card {
    max-width: 600px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.avatar-upload {
    text-align: center;
    margin-bottom: 25px;
}

.avatar-input-container {
    position: relative;
    display: inline-block;
}

#avatar-preview {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e9ecef;
    margin-bottom: 10px;
}

#avatar {
    display: none;
}

.avatar-upload-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 15px;
    background: #667eea;
    color: white;
    border-radius: 20px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.avatar-upload-btn:hover {
    background: #764ba2;
    transform: translateY(-1px);
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }
}
</style>

<script>
function previewAvatar() {
    const input = document.getElementById('avatar');
    const preview = document.getElementById('avatar-preview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

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
</script>
@endsection