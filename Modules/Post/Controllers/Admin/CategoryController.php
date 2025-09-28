<?php

namespace Modules\Post\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Post\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('Post::admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('Post::admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|string|max:255',
        ], [
            'name.required' => 'نام دسته‌بندی الزامی است.',
            'name.unique' => 'این نام دسته‌بندی قبلاً استفاده شده است.',
            'name.max' => 'نام دسته‌بندی نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی با موفقیت ایجاد شد.');
    }

    public function show(Category $category)
    {
        return view('Post::admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('Post::admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'نام دسته‌بندی الزامی است.',
            'name.unique' => 'این نام دسته‌بندی قبلاً استفاده شده است.',
            'name.max' => 'نام دسته‌بندی نمی‌تواند بیشتر از ۲۵۵ کاراکتر باشد.',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی با موفقیت بروزرسانی شد.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }
}