<?php

namespace App\Helpers;

use Modules\Post\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryHelper
{
    public static function getAllWithCount()
    {
        return Cache::remember('categories_with_count', 60, function () {
            return Category::withCount('posts')->orderBy('name')->get();
        });
    }
    
    public static function getPopular($limit = 5)
    {
        return Cache::remember("popular_categories_{$limit}", 60, function () use ($limit) {
            return Category::withCount('posts')
                          ->orderBy('posts_count', 'desc')
                          ->limit($limit)
                          ->get();
        });
    }
    
    public static function clearCache()
    {
        Cache::forget('categories_with_count');
        // پاک کردن تمام cache های مربوط به دسته‌بندی
        $keys = ['popular_categories_5', 'popular_categories_10'];
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}