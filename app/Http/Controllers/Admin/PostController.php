<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Post\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $posts = Post::with(['user', 'category'])
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'published' => $request->has('published'),
            'user_id' => auth()->id(),
            'published_at' => $request->has('published') ? now() : null,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
        ];

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        Post::create($data);

        Cache::forget('home_page_data');

        return redirect()->route('admin.posts.index')->with('success', 'پست با موفقیت ایجاد شد');
    }

    public function show(Post $post)
    {
        $post = Post::with(['user', 'category'])->findOrFail($post->id);
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'content' => $request->content,
            'excerpt' => $request->excerpt,
            'published' => $request->has('published'),
            'published_at' => $request->has('published') ? ($post->published_at ?? now()) : null,
            'category_id' => $request->category_id,
            'slug' => Str::slug($request->title),
        ];

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        $post->update($data);

        Cache::forget('home_page_data');

        return redirect()->route('admin.posts.index')->with('success', 'پست بروزرسانی شد');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        Cache::forget('home_page_data');

        return redirect()->route('admin.posts.index')->with('success', 'پست حذف شد');
    }

    public function preview(Post $post)
    {
        $post = Post::with(['user', 'category'])->findOrFail($post->id);
        return view('admin.posts.preview', compact('post'));
    }
}