<?php

namespace Modules\Post\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Post\Models\Post;

class LikeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Toggle the like status for a post.
     *
     * @param  \Modules\Post\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleLike(Post $post)
    {
        $user = Auth::user();

        // The toggle method attaches if not attached, and detaches if attached.
        $user->likedPosts()->toggle($post->id);

        $isLiked = $user->likedPosts()->where('post_id', $post->id)->exists();
        $message = $isLiked ? 'پست با موفقیت لایک شد!' : 'لایک شما برداشته شد.';

        return back()->with('success', $message);
    }
}