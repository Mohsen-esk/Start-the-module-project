<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Post\Models\Post;
use Modules\Auth\Models\User;
use Modules\Post\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * نمایش صفحه اصلی با داده‌های کش‌شده
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // کش برای 30 دقیقه
            $data = Cache::remember('home_page_data', 30 * 60, function () {
                return $this->getHomeData();
            });

            return view('home', $data);
        } catch (\Exception $e) {
            Log::error('Home Controller Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return view('home', $this->getEmptyData());
        }
    }

    /**
     * دریافت داده‌های صفحه اصلی
     *
     * @return array
     */
    private function getHomeData()
    {
        // دریافت آخرین پست‌ها (8 پست اخیر)
        $recentPosts = Post::with(['user', 'category'])
            ->whereIn('status', ['published', 'active'])
            ->latest('created_at')
            ->take(8)
            ->get()
            ->each(function ($post) {
                if ($post->slug === '') {
                    $post->slug = null;
                }
            });

        Log::info('Recent Posts Count: ' . $recentPosts->count(), ['posts' => $recentPosts->toArray()]);

        // پیدا کردن دسته‌بندی‌ها
        $categoriesMap = $this->findCategories();

        // دریافت پست‌ها بر اساس دسته‌بندی
        $recentNotes = $this->getPostsByCategory(
            $categoriesMap['notes'],
            ['دلنوشته', 'احساس', 'عشق', 'غم', 'دل', 'قلب', 'عاشقانه'],
            4
        );

        $recentBooks = $this->getPostsByCategory(
            $categoriesMap['books'],
            ['کتاب', 'داستان', 'رمان', 'حماسه', 'ادبیات', 'نوشته'],
            4
        );

        $recentPoems = $this->getPostsByCategory(
            $categoriesMap['poems'],
            ['شعر', 'غزل', 'قطعه', 'رباعی', 'نظم', 'شاعری'],
            4
        );

        $recentMovies = $this->getPostsByCategory(
            $categoriesMap['movies'],
            ['فیلم', 'سینما', 'مستند', 'ویدیو', 'فیلم کوتاه'],
            4
        );

        // محاسبه آمار
        $stats = $this->calculateStats($categoriesMap);

        return compact('recentPosts', 'recentNotes', 'recentBooks', 'recentPoems', 'recentMovies', 'stats');
    }

    /**
     * پیدا کردن دسته‌بندی‌ها بر اساس نام یا slug
     *
     * @return array
     */
    private function findCategories()
    {
        $notesCategory = Category::where(function ($query) {
            $query->where('name', 'like', '%دلنوشته%')
                ->orWhere('name', 'like', '%احساس%')
                ->orWhere('name', 'like', '%عشق%')
                ->orWhere('name', 'like', '%قلب%')
                ->orWhere('slug', 'like', '%note%')
                ->orWhere('slug', 'like', '%heart%')
                ->orWhere('slug', 'like', '%feeling%');
        })->first();

        $booksCategory = Category::where(function ($query) {
            $query->where('name', 'like', '%کتاب%')
                ->orWhere('name', 'like', '%داستان%')
                ->orWhere('name', 'like', '%رمان%')
                ->orWhere('name', 'like', '%ادبیات%')
                ->orWhere('slug', 'like', '%book%')
                ->orWhere('slug', 'like', '%story%')
                ->orWhere('slug', 'like', '%novel%');
        })->first();

        $poemsCategory = Category::where(function ($query) {
            $query->where('name', 'like', '%شعر%')
                ->orWhere('name', 'like', '%غزل%')
                ->orWhere('name', 'like', '%قطعه%')
                ->orWhere('name', 'like', '%نظم%')
                ->orWhere('slug', 'like', '%poem%')
                ->orWhere('slug', 'like', '%poetry%')
                ->orWhere('slug', 'like', '%verse%');
        })->first();

        $moviesCategory = Category::where(function ($query) {
            $query->where('name', 'like', '%فیلم%')
                ->orWhere('name', 'like', '%سینما%')
                ->orWhere('name', 'like', '%مستند%')
                ->orWhere('name', 'like', '%ویدیو%')
                ->orWhere('slug', 'like', '%movie%')
                ->orWhere('slug', 'like', '%film%')
                ->orWhere('slug', 'like', '%video%');
        })->first();

        $wordsOfWisdomCategory = Category::where(function ($query) {
            $query->where('name', 'like', '%حرف حق%')
                ->orWhere('name', 'like', '%حکمت%')
                ->orWhere('slug', 'like', '%wisdom%');
        })->first();

        $motivationalCategory = Category::where(function ($query) {
            $query->where('name', 'like', '%انگیزشی%')
                ->orWhere('name', 'like', '%موفقیت%')
                ->orWhere('slug', 'like', '%motivational%');
        })->first();

        Log::info('Found Categories: ', [
            'notes' => $notesCategory ? $notesCategory->toArray() : null,
            'books' => $booksCategory ? $booksCategory->toArray() : null,
            'poems' => $poemsCategory ? $poemsCategory->toArray() : null,
            'movies' => $moviesCategory ? $moviesCategory->toArray() : null,
            'words_of_wisdom' => $wordsOfWisdomCategory ? $wordsOfWisdomCategory->toArray() : null,
            'motivational' => $motivationalCategory ? $motivationalCategory->toArray() : null,
        ]);

        return [
            'notes' => $notesCategory,
            'books' => $booksCategory,
            'poems' => $poemsCategory,
            'movies' => $moviesCategory,
            'words_of_wisdom' => $wordsOfWisdomCategory,
            'motivational' => $motivationalCategory
        ];
    }

    /**
     * دریافت پست‌ها بر اساس دسته‌بندی یا کلیدواژه‌ها
     *
     * @param \App\Models\Category|null $category
     * @param array $keywords
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    private function getPostsByCategory($category, array $keywords, int $limit = 4)
    {
        $query = Post::with(['user', 'category'])->whereIn('status', ['published', 'active']);

        if ($category) {
            $query->where('category_id', $category->id);
        } else {
            $query->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('title', 'like', "%{$keyword}%")
                      ->orWhere('content', 'like', "%{$keyword}%");
                }
            });
        }

        $posts = $query->latest('created_at')->take($limit)->get()->each(function ($post) {
            if ($post->slug === '') {
                $post->slug = null;
            }
        });
        Log::info("Posts fetched for category: " . ($category ? $category->name : 'No Category'), [
            'count' => $posts->count(),
            'posts' => $posts->toArray()
        ]);

        return $posts;
    }

    /**
     * محاسبه آمار سایت
     *
     * @param array $categoriesMap
     * @return array
     */
    private function calculateStats($categoriesMap)
    {
        $totalPosts = Post::whereIn('status', ['published', 'active'])->count();

        $notesCount = 0;
        if ($categoriesMap['notes']) {
            $notesCount += Post::whereIn('status', ['published', 'active'])
                ->where('category_id', $categoriesMap['notes']->id)
                ->count();
        }
        $notesCount += Post::whereIn('status', ['published', 'active'])
            ->where(function ($query) {
                $query->where('title', 'like', '%دلنوشته%')
                      ->orWhere('title', 'like', '%احساس%')
                      ->orWhere('title', 'like', '%عشق%')
                      ->orWhere('content', 'like', '%دلنوشته%');
            })
            ->when($categoriesMap['notes'], function ($query, $category) {
                return $query->where('category_id', '!=', $category->id);
            })
            ->count();

        $booksCount = 0;
        if ($categoriesMap['books']) {
            $booksCount += Post::whereIn('status', ['published', 'active'])
                ->where('category_id', $categoriesMap['books']->id)
                ->count();
        }
        $booksCount += Post::whereIn('status', ['published', 'active'])
            ->where(function ($query) {
                $query->where('title', 'like', '%کتاب%')
                      ->orWhere('title', 'like', '%داستان%')
                      ->orWhere('title', 'like', '%رمان%');
            })
            ->when($categoriesMap['books'], function ($query, $category) {
                return $query->where('category_id', '!=', $category->id);
            })
            ->count();

        $poemsCount = 0;
        if ($categoriesMap['poems']) {
            $poemsCount += Post::whereIn('status', ['published', 'active'])
                ->where('category_id', $categoriesMap['poems']->id)
                ->count();
        }
        $poemsCount += Post::whereIn('status', ['published', 'active'])
            ->where(function ($query) {
                $query->where('title', 'like', '%شعر%')
                      ->orWhere('title', 'like', '%غزل%')
                      ->orWhere('title', 'like', '%قطعه%');
            })
            ->when($categoriesMap['poems'], function ($query, $category) {
                return $query->where('category_id', '!=', $category->id);
            })
            ->count();

        $moviesCount = 0;
        if ($categoriesMap['movies']) {
            $moviesCount += Post::whereIn('status', ['published', 'active'])
                ->where('category_id', $categoriesMap['movies']->id)
                ->count();
        }
        $moviesCount += Post::whereIn('status', ['published', 'active'])
            ->where(function ($query) {
                $query->where('title', 'like', '%فیلم%')
                      ->orWhere('title', 'like', '%سینما%')
                      ->orWhere('title', 'like', '%مستند%');
            })
            ->when($categoriesMap['movies'], function ($query, $category) {
                return $query->where('category_id', '!=', $category->id);
            })
            ->count();

        $wordsOfWisdomCount = 0;
        if ($categoriesMap['words_of_wisdom']) {
            $wordsOfWisdomCount += Post::whereIn('status', ['published', 'active'])
                ->where('category_id', $categoriesMap['words_of_wisdom']->id)
                ->count();
        }
        $wordsOfWisdomCount += Post::whereIn('status', ['published', 'active'])
            ->where(function ($query) {
                $query->where('title', 'like', '%حرف حق%')
                      ->orWhere('title', 'like', '%حکمت%')
                      ->orWhere('content', 'like', '%پند%')
                      ->orWhere('content', 'like', '%سخن بزرگان%');
            })
            ->when($categoriesMap['words_of_wisdom'], function ($query, $category) {
                return $query->where('category_id', '!=', $category->id);
            })
            ->count();

        $motivationalCount = 0;
        if ($categoriesMap['motivational']) {
            $motivationalCount += Post::whereIn('status', ['published', 'active'])
                ->where('category_id', $categoriesMap['motivational']->id)
                ->count();
        }
        $motivationalCount += Post::whereIn('status', ['published', 'active'])
            ->where(function ($query) {
                $query->where('title', 'like', '%انگیزشی%')
                      ->orWhere('title', 'like', '%موفقیت%')
                      ->orWhere('content', 'like', '%تلاش%')
                      ->orWhere('content', 'like', '%پیشرفت%');
            })
            ->when($categoriesMap['motivational'], function ($query, $category) {
                return $query->where('category_id', '!=', $category->id);
            })
            ->count();

        return [
            'total_posts' => $totalPosts,
            'total_users' => User::count(),
            'total_notes' => $notesCount,
            'total_books' => $booksCount,
            'total_poems' => $poemsCount,
            'total_movies' => $moviesCount,
            'total_words_of_wisdom' => $wordsOfWisdomCount,
            'total_motivational' => $motivationalCount,
            'total_views' => Post::whereIn('status', ['published', 'active'])->sum('views_count') ?: 0,
            'total_likes' => Post::whereIn('status', ['published', 'active'])->sum('likes_count') ?: 0,
        ];
    }

    /**
     * داده‌های پیش‌فرض برای حالت خطا
     *
     * @return array
     */
    private function getEmptyData()
    {
        $recentPosts = collect([]);
        $recentNotes = collect([]);
        $recentBooks = collect([]);
        $recentPoems = collect([]);
        $recentMovies = collect([]);
        $stats = [
            'total_posts' => 0,
            'total_users' => 0,
            'total_notes' => 0,
            'total_books' => 0,
            'total_poems' => 0,
            'total_movies' => 0,
            'total_words_of_wisdom' => 0,
            'total_motivational' => 0,
            'total_views' => 0,
            'total_likes' => 0,
        ];

        return compact('recentPosts', 'recentNotes', 'recentBooks', 'recentPoems', 'recentMovies', 'stats');
    }

    /**
     * پاک کردن کش صفحه اصلی
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache()
    {
        Cache::forget('home_page_data');
        return redirect()->route('home')->with('success', 'کش صفحه اصلی پاک شد');
    }

    /**
     * دریافت آمار سایت برای API
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStats()
    {
        try {
            $categoriesMap = $this->findCategories();
            $stats = $this->calculateStats($categoriesMap);
            
            return response()->json($stats);
        } catch (\Exception $e) {
            Log::error('Error getting stats: ' . $e->getMessage());
            return response()->json(['error' => 'خطا در دریافت آمار'], 500);
        }
    }

    /**
     * جستجوی سریع برای AJAX
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickSearch(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $posts = Post::with(['user', 'category'])
            ->whereIn('status', ['published', 'active'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('content', 'like', '%' . $query . '%');
            })
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($post) {
                if ($post->slug === '') {
                    $post->slug = null;
                }
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'excerpt' => \Str::limit(strip_tags($post->content), 100),
                    'author' => $post->user->name ?? 'نویسنده ناشناس',
                    'category' => $post->category->name ?? 'عمومی',
                    'url' => route('posts.show', $post->slug ?? $post->id)
                ];
            });

        return response()->json(['results' => $posts]);
    }
    /**
 * نمایش صفحه معرفی سایت
 */
public function about()
{
    return view('layouts.about');
}

    /**
     * نمایش پست‌های دسته‌بندی دلنوشته
     *
     * @return \Illuminate\View\View
     */
    public function getNotesByCategory()
    {
        $categoriesMap = $this->findCategories();
        $notes = $this->getPostsByCategory(
            $categoriesMap['notes'],
            ['دلنوشته', 'احساس', 'عشق', 'غم', 'دل', 'قلب'],
            12
        );

        return view('Post::posts.category', [
            'posts' => $notes,
            'categoryName' => 'دلنوشته‌ها',
            'categoryDescription' => 'احساسات درونی که به کلمات تبدیل شده‌اند'
        ]);
    }

    /**
     * نمایش پست‌های دسته‌بندی کتاب
     *
     * @return \Illuminate\View\View
     */
    public function getBooksByCategory()
    {
        $categoriesMap = $this->findCategories();
        $books = $this->getPostsByCategory(
            $categoriesMap['books'],
            ['کتاب', 'داستان', 'رمان', 'حماسه', 'ادبیات'],
            12
        );

        return view('Post::posts.category', [
            'posts' => $books,
            'categoryName' => 'کتاب‌ها',
            'categoryDescription' => 'مجموعه‌ای از بهترین آثار ادبی و داستان‌ها'
        ]);
    }

    /**
     * نمایش پست‌های دسته‌بندی شعر
     *
     * @return \Illuminate\View\View
     */
    public function getPoemsByCategory()
    {
        $categoriesMap = $this->findCategories();
        $poems = $this->getPostsByCategory(
            $categoriesMap['poems'],
            ['شعر', 'غزل', 'قطعه', 'رباعی', 'نظم'],
            12
        );

        return view('Post::posts.category', [
            'posts' => $poems,
            'categoryName' => 'شعرها',
            'categoryDescription' => 'زیباترین اشعار و غزلیات'
        ]);
    }

    /**
     * نمایش پست‌های دسته‌بندی فیلم
     *
     * @return \Illuminate\View\View
     */
    public function getMoviesByCategory()
    {
        $categoriesMap = $this->findCategories();
        $movies = $this->getPostsByCategory(
            $categoriesMap['movies'],
            ['فیلم', 'سینما', 'مستند', 'ویدیو', 'فیلم کوتاه'],
            12
        );

        return view('Post::posts.category', [
            'posts' => $movies,
            'categoryName' => 'فیلم‌ها',
            'categoryDescription' => 'مجموعه‌ای از بهترین آثار سینمایی و ویدیوها'
        ]);
    }

    /**
     * نمایش پست‌های دسته‌بندی حرف حق
     *
     * @return \Illuminate\View\View
     */
    public function getWordsOfWisdomByCategory()
    {
        $categoriesMap = $this->findCategories();
        $posts = $this->getPostsByCategory(
            $categoriesMap['words_of_wisdom'],
            ['حرف حق', 'حکمت', 'پند', 'سخن بزرگان'],
            12
        );

        return view('Post::posts.category', [
            'posts' => $posts,
            'categoryName' => 'حرف حق',
            'categoryDescription' => 'مجموعه‌ای از سخنان حکیمانه و پندآموز'
        ]);
    }

    /**
     * نمایش پست‌های دسته‌بندی انگیزشی
     *
     * @return \Illuminate\View\View
     */
    public function getMotivationalByCategory()
    {
        $categoriesMap = $this->findCategories();
        $posts = $this->getPostsByCategory(
            $categoriesMap['motivational'],
            ['انگیزشی', 'موفقیت', 'تلاش', 'پیشرفت'],
            12
        );

        return view('Post::posts.category', [
            'posts' => $posts,
            'categoryName' => 'انگیزشی',
            'categoryDescription' => 'مطالبی برای افزایش انگیزه و امید به آینده'
        ]);
    }
}