<?php

namespace Modules\Post\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Post\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        // Assuming permissions are handled by a middleware group in routes.
    }

    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('Post::admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('Post::admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpg,png|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
        ]);

        $data = $request->only('title', 'content', 'excerpt', 'meta_title', 'meta_description', 'status');
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);
        $data['published'] = $request->status === 'published';
        $data['published_at'] = $request->status === 'published' ? now() : null;
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        Post::create($data);
        return redirect()->route('admin.posts.index')->with('success', 'پست اضافه شد.');
    }

    public function edit(Post $post)
    {
        return view('Post::admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|string',
            'featured_image' => 'nullable|image|mimes:jpg,png|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
        ]);

        $data = $request->only('title', 'content', 'excerpt', 'meta_title', 'meta_description', 'status');
        $data['slug'] = Str::slug($request->title);
        $data['published'] = $request->status === 'published';
        $data['published_at'] = $request->status === 'published' ? now() : null;
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update($data);
        return redirect()->route('admin.posts.index')->with('success', 'پست ویرایش شد.');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'پست حذف شد.');
    }

    public function preview(Post $post)
    {
        return view('Post::admin.posts.preview', compact('post'));
    }
}