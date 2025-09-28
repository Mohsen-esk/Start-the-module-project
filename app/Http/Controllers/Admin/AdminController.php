<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Post\Models\Post;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalPosts' => Post::count(),
            'usersToday' => User::whereDate('created_at', today())->count(),
            'postsToday' => Post::whereDate('created_at', today())->count(),
        ];

        $latestUsers = User::latest()->take(5)->get();
        $latestPosts = Post::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestUsers', 'latestPosts'));
    }

    public function users(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        $user->update(['role' => $request->role]);
        return redirect()->route('admin.users')->with('success', 'نقش کاربر بروزرسانی شد');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'نمی‌توانید خودتان را حذف کنید');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'کاربر حذف شد');
    }

    public function activityLog()
    {
        $activities = Activity::with(['causer', 'subject'])
            ->latest()
            ->paginate(20);

        return view('admin.activity_log.index', compact('activities'));
    }
}