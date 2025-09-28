<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Post\Models\Post; // فرض می‌کنیم مدل Post برای محتواها وجود دارد

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->query('q');
        $results = Post::with('user', 'category') // Eager load relationships
                       ->where('title', 'like', "%$query%")
                       ->orWhere('content', 'like', "%$query%")
                       ->orWhereHas('category', function ($q) use ($query) {
                           $q->where('name', 'like', "%$query%");
                       })
                       ->paginate(9); // Paginate results
        return view('search', compact('results', 'query'));
    }

    public function suggestions(Request $request)
    {
        $query = $request->query('q');
        $results = Post::with('category')->where('title', 'like', "%$query%")
                       ->orWhere('content', 'like', "%$query%")
                       ->orWhereHas('category', function ($q) use ($query) {
                           $q->where('name', 'like', "%$query%");
                       })
                       ->take(10)
                       ->get()
                       ->map(function ($post) {
                           return [
                               'title' => $post->title,
                               'url' => route('posts.show', $post->slug ?? $post->id),
                               'category' => $post->category->name ?? 'بدون دسته',
                               'icon' => $this->getCategoryIcon($post->category->name ?? '')
                           ];
                       });
        return response()->json($results);
    }

    private function getCategoryIcon($category)
    {
        return match ($category) {
            'شعر' => 'fa-book-open',
            'دلنوشته' => 'fa-pen-nib',
            'کتاب' => 'fa-book',
            'فیلم' => 'fa-film',
            'هنرمندان' => 'fa-user',
            default => 'fa-search',
        };
    }
}