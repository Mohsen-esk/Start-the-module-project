<?php

namespace Modules\Post\Controllers;

use Modules\Post\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SavedPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's saved posts.
     */
    public function index()
    {
        $savedPosts = Auth::user()->savedPosts()->latest()->paginate(9);
        
        return view('dashboard.saved', [
            'posts' => $savedPosts
        ]);
    }

    /**
     * Toggle the save status of a post.
     */
    public function toggleSave(Post $post)
    {
        $user = Auth::user();
        
        // toggle() will attach if not attached, and detach if attached.
        $user->savedPosts()->toggle($post->id);

        $isSaved = $user->savedPosts()->where('post_id', $post->id)->exists();
        $message = $isSaved ? 'پست با موفقیت ذخیره شد!' : 'پست از لیست ذخیره‌ها حذف شد.';

        return back()->with('success', $message);
    }
}
