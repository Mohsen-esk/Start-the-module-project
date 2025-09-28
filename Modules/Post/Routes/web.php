<?php

use Illuminate\Support\Facades\Route;
use Modules\Post\Controllers\PostController;
use Modules\Post\Controllers\SavedPostController;

// Public Post Routes
Route::get('/all-posts', [PostController::class, 'allPosts'])->name('posts.all_public');

// User-specific routes (Posts, Saved Posts, etc.)
Route::middleware('auth')->group(function () {
    // پست‌های کاربری (غیر ادمین)
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/published', [PostController::class, 'published'])->name('posts.published');
    Route::get('/posts/views', [PostController::class, 'views'])->name('posts.views');
    Route::get('/posts/likes', [PostController::class, 'likes'])->name('posts.likes');
    Route::get('/posts/all', [PostController::class, 'all'])->name('posts.all');

    // برای سازگاری با view
    Route::get('/articles/create', [PostController::class, 'create'])->name('articles.create');

    // Saved Posts
    Route::post('/posts/{post}/save', [SavedPostController::class, 'toggleSave'])->name('posts.save');
    Route::get('/dashboard/saved', [SavedPostController::class, 'index'])->name('dashboard.saved');
});

// API Routes
Route::prefix('api')->group(function () {
    Route::get('posts/category/{category}', [PostController::class, 'getByCategory']);
});