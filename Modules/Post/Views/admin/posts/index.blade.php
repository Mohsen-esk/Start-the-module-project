
<div class="flex min-h-screen bg-gray-100 dir-rtl">
    <!-- Sidebar -->
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
            <h1 class="text-3xl font-bold text-gray-800 mb-2">مدیریت پست‌ها</h1>
            <p class="text-gray-600">لیست پست‌ها و مدیریت آن‌ها</p>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Search Form -->
        <div class="mb-6">
            <form method="GET" action="{{ route('admin.posts.index') }}" class="flex items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="جستجو بر اساس عنوان یا نویسنده" class="w-full md:w-1/3 p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="mr-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">جستجو</button>
            </form>
        </div>

        <!-- Posts Table -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">لیست پست‌ها</h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-right">عنوان</th>
                            <th class="px-4 py-2 text-right">نویسنده</th>
                            <th class="px-4 py-2 text-right">وضعیت</th>
                            <th class="px-4 py-2 text-right">تاریخ انتشار</th>
                            <th class="px-4 py-2 text-right">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $post->title }}</td>
                            <td class="px-4 py-2">{{ $post->user->name }}</td>
                            <td class="px-4 py-2">{{ $post->published ? 'منتشر شده' : 'پیش‌نویس' }}</td>
                            <td class="px-4 py-2">{{ $post->published_at ? $post->published_at->format('Y-m-d') : '-' }}</td>
                            <td class="px-4 py-2 flex space-x-2 space-x-reverse">
                                <a href="{{ route('admin.posts.show', $post->id) }}" class="text-blue-600 hover:underline">مشاهده</a>
                                <a href="{{ route('admin.posts.edit', $post->id) }}" class="text-green-600 hover:underline">ویرایش</a>
                                <a href="{{ route('admin.posts.preview', $post->id) }}" class="text-purple-600 hover:underline">پیش‌نمایش</a>
                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('آیا مطمئن هستید که می‌خواهید این پست را حذف کنید؟')" class="text-red-600 hover:underline">حذف</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-center text-gray-600">هیچ پستی یافت نشد.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-6">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Tailwind CSS CDN for development -->
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<style>
    .dir-rtl { direction: rtl; text-align: right; }
</style>
