<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('Auth::login');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('Auth::register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل صحیح نیست',
            'password.required' => 'رمز عبور الزامی است',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // بررسی نقش کاربر
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'خوش آمدید به پنل ادمین!');
            }

            return redirect()->intended(route('dashboard'))->with('success', 'خوش آمدید!');
        }

        throw ValidationException::withMessages([
            'email' => ['اطلاعات ورود صحیح نیست.'],
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['nullable', 'string', 'max:20'],
            'work_field' => ['nullable', 'string', 'max:255'],
        ], [
            'full_name.required' => 'نام کامل الزامی است',
            'full_name.max' => 'نام کامل نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد',
            'nickname.max' => 'نام مستعار نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد',
            'nickname.unique' => 'این نام مستعار قبلاً استفاده شده است',
            'email.required' => 'ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل صحیح نیست',
            'email.unique' => 'این ایمیل قبلاً ثبت شده است',
            'password.required' => 'رمز عبور الزامی است',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد',
            'password.confirmed' => 'تایید رمز عبور مطابقت ندارد',
            'phone.max' => 'شماره تلفن نمی‌تواند بیشتر از ۲۰ کاراکتر باشد',
            'work_field.max' => 'زمینه کاری نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->full_name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'work_field' => $request->work_field,
            'status' => 'active',
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'حساب کاربری شما با موفقیت ایجاد شد!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('success', 'با موفقیت خارج شدید');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $posts_count = Post::where('user_id', $user->id)->count();
        $published_posts_count = Post::where('user_id', $user->id)->where('published', true)->count();
        $recent_posts = Post::where('user_id', $user->id)->where('published', true)->latest()->take(3)->get();
        $total_views = Post::where('user_id', $user->id)->where('published', true)->sum('views_count');
        $total_likes = Post::where('user_id', $user->id)->where('published', true)->sum('likes_count');

        return view('Auth::dashboard', compact('user', 'posts_count', 'published_posts_count', 'recent_posts', 'total_views', 'total_likes'));
    }

    public function profile()
    {
        return view('Auth::profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255', 'unique:users,nickname,' . $user->id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'work_field' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            'full_name.required' => 'نام کامل الزامی است',
            'full_name.max' => 'نام کامل نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد',
            'nickname.max' => 'نام مستعار نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد',
            'nickname.unique' => 'این نام مستعار متعلق به کاربر دیگری است',
            'email.required' => 'ایمیل الزامی است',
            'email.email' => 'فرمت ایمیل صحیح نیست',
            'email.unique' => 'این ایمیل متعلق به کاربر دیگری است',
            'password.min' => 'رمز عبور باید حداقل ۸ کاراکتر باشد',
            'password.confirmed' => 'تایید رمز عبور مطابقت ندارد',
            'phone.max' => 'شماره تلفن نمی‌تواند بیشتر از ۲۰ کاراکتر باشد',
            'work_field.max' => 'زمینه کاری نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد',
            'avatar.image' => 'فایل انتخابی باید یک تصویر باشد',
            'avatar.mimes' => 'فرمت‌های مجاز تصویر: jpeg, png, jpg, gif',
            'avatar.max' => 'حجم تصویر نمی‌تواند بیشتر از ۲ مگابایت باشد',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'name' => $request->full_name,
            'nickname' => $request->nickname,
            'email' => $request->email,
            'phone' => $request->phone,
            'work_field' => $request->work_field,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->getRawOriginal('avatar')) {
                Storage::disk('public')->delete('avatars/' . $user->getRawOriginal('avatar'));
            }

            $avatarName = $user->id . '_' . time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->storeAs('avatars', $avatarName, 'public');
            $updateData['avatar'] = $avatarName;
        }

        $user->update($updateData);

        return back()->with('success', 'پروفایل شما با موفقیت به‌روزرسانی شد');
    }
}

