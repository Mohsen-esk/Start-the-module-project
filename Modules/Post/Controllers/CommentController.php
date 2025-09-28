<?php

namespace Modules\Post\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Post\Models\Post;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Post\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ], [
            'content.required' => 'نوشتن متن کامنت الزامی است.',
            'content.min' => 'متن کامنت باید حداقل ۳ کاراکتر باشد.',
            'content.max' => 'متن کامنت نمی‌تواند بیشتر از ۱۰۰۰ کاراکتر باشد.',
        ]);

        $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'نظر شما با موفقیت ثبت شد.');
    }
}