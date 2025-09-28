<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پیش‌نمایش پست</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .dir-rtl { direction: rtl; text-align: right; }
        .post-content img { max-width: 100%; height: auto; }
        .post-content { line-height: 1.8; }
    </style>
</head>
<body class="bg-gray-100 dir-rtl">
    <div class="flex min-h-screen">
        <!-- Sidebar (مشابه کد شما) -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800">پنل ادمین</h2>
            </div>
            <nav class="mt-4">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600 {{ Route::is('admin.dashboard') ? 'bg-blue-100 text-blue-600' : '' }}">
                            داشبورد
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" class="block px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600 {{ Route::is('admin.users') ? 'bg-blue-100 text-blue-600' : '' }}">
                            مدیریت کاربران
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.posts.index') }}" class="block px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600 {{ Route::is('admin.posts.index') ? 'bg-blue-100 text-blue-600' : '' }}">
                            مدیریت پست‌ها
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.posts.create') }}" class="block px-6 py-3 text-gray-700 hover:bg-blue-100 hover:text-blue-600 {{ Route::is('admin.posts.create') ? 'bg-blue-100 text-blue-600' : '' }}">
                            ایجاد پست جدید
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">پیش‌نمایش پست</h1>
                <p class="text-gray-600">مشاهده پیش‌نمایش پست قبل از انتشار</p>
            </div>

            <!-- Post Preview -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $post->title }}</h2>
                <div class="text-gray-600 mb-4">
                    <p><strong>نویسنده:</strong> {{ $post->user->name }}</p>
                    <p><strong>وضعیت:</strong> {{ $post->published ? 'منتشر شده' : 'پیش‌نویس' }}</p>
                    <p><strong>تاریخ انتشار:</strong> {{ $post->published_at ? $post->published_at->format('Y-m-d H:i') : 'انتشار نیافته' }}</p>
                    @if($post->category)
                        <p><strong>دسته‌بندی:</strong> {{ $post->category->name }}</p>
                    @endif
                </div>
                <div class="post-content prose max-w-none">
                    {!! $post->content !!}
                </div>
                @if($post->image)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="rounded-lg">
                    </div>
                @endif
                <div class="mt-6 flex space-x-4 space-x-reverse">
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">ویرایش پست</a>
                    <a href="{{ route('admin.posts.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">بازگشت به لیست</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>