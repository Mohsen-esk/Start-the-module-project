{{-- resources/views/admin/posts/edit.blade.php --}}
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ویرایش پست - {{ e($post->title) }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Vazirmatn', 'Tahoma', sans-serif;
        }

        body {
            background: #f5f7fa;
            min-height: 100vh;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px #3b82f6;
            border-color: transparent;
        }

        .form-input.error {
            border-color: #ef4444;
        }

        .editor-toolbar {
            border: 1px solid #d1d5db;
            border-bottom: none;
            border-radius: 0.5rem 0.5rem 0 0;
            background: #f9fafb;
            padding: 0.5rem;
        }

        .editor-button {
            padding: 0.5rem;
            margin: 0 0.25rem;
            border: none;
            background: transparent;
            border-radius: 0.25rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .editor-button:hover {
            background: #e5e7eb;
        }

        .editor-content {
            border: 1px solid #d1d5db;
            border-top: none;
            border-radius: 0 0 0.5rem 0.5rem;
            min-height: 200px;
        }

        .hover-transition {
            transition: all 0.2s ease;
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .btn-primary {
            background-color: #3b82f6;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.2s ease;
            border-radius: 8px;
            margin: 4px 12px;
        }

        .sidebar-link:hover {
            background: #f3f4f6;
            color: #3b82f6;
            transform: translateX(-4px);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen bg-gray-100 dir-rtl">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800">پنل ادمین</h2>
            </div>
            <nav class="mt-4">
                <ul>
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                </svg>
                                داشبورد
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users') }}" class="sidebar-link {{ Route::is('admin.users') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                مدیریت کاربران
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.posts.index') }}" class="sidebar-link {{ Route::is('admin.posts.index') || Route::is('admin.posts.edit') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                مدیریت پست‌ها
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.posts.create') }}" class="sidebar-link {{ Route::is('admin.posts.create') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                ایجاد پست جدید
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="sidebar-link {{ Route::is('admin.categories.*') ? 'active' : '' }}">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                </svg>
                                مدیریت دسته‌بندی‌ها
                            </div>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-6">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">ویرایش پست</h1>
                        <p class="text-gray-600">فرم زیر را برای ویرایش پست تکمیل کنید</p>
                    </div>
                    <div class="flex space-x-3 space-x-reverse">
                        <a href="{{ route('admin.posts.show', $post->id) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 hover-transition">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                مشاهده پست
                            </div>
                        </a>
                        <a href="{{ route('admin.posts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 hover-transition">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                بازگشت
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form Container -->
            <div class="bg-white rounded-lg card-shadow p-8">
                <form method="POST" action="{{ route('admin.posts.update', $post->id) }}" id="postForm">
                    @csrf
                    @method('PUT')

                    <!-- Success/Error Messages -->
                    @if (session('success'))
                        <div class="bg-green-50 border-r-4 border-green-400 text-green-800 px-6 py-4 rounded-xl mb-6 shadow-sm">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle ml-3 text-green-600"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-50 border-r-4 border-red-400 text-red-800 px-6 py-4 rounded-xl mb-6 shadow-sm">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-circle ml-3 text-red-600"></i>
                                <span class="font-medium">خطاهای زیر رخ داده است:</span>
                            </div>
                            <ul class="mr-6 mt-2 list-disc space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- عنوان -->
                    <div class="form-group">
                        <label for="title" class="form-label">
                            عنوان پست <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title"
                               name="title" 
                               value="{{ old('title', $post->title) }}"
                               class="form-input @error('title') error @enderror" 
                               placeholder="عنوان جذاب و خواندنی برای پست خود وارد کنید"
                               required>
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- دسته‌بندی -->
                    <div class="form-group">
                        <label for="category_id" class="form-label">
                            دسته‌بندی <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" name="category_id" class="form-input @error('category_id') error @enderror" required>
                            <option value="">انتخاب دسته‌بندی</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        @if ($categories->isEmpty())
                            <p class="mt-2 text-sm text-gray-500">
                                هیچ دسته‌بندی‌ای وجود ندارد. 
                                <a href="{{ route('admin.categories.create') }}" class="text-blue-600 hover:underline">ایجاد دسته‌بندی جدید</a>
                            </p>
                        @endif
                    </div>

                    <!-- محتوا با ادیتور ساده -->
                    <div class="form-group">
                        <label for="content" class="form-label">
                            محتوای پست <span class="text-red-500">*</span>
                        </label>
                        
                        <!-- Simple Editor Toolbar -->
                        <div class="editor-toolbar">
                            <button type="button" class="editor-button" onclick="formatText('bold')" title="ضخیم">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"></path>
                                </svg>
                            </button>
                            <button type="button" class="editor-button" onclick="formatText('italic')" title="کج">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4l-2 14M18 4l-2 14"></path>
                                </svg>
                            </button>
                            <button type="button" class="editor-button" onclick="insertText('### ')" title="سرتیتر">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <textarea id="content"
                                  name="content" 
                                  rows="12"
                                  class="form-input editor-content @error('content') error @enderror" 
                                  placeholder="محتوای اصلی پست را اینجا بنویسید... 

می‌توانید از Markdown استفاده کنید:
- **متن ضخیم**
- *متن کج*
- ### سرتیتر
- [لینک](http://example.com)
- ![تصویر](url)"
                                  required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- دکمه‌های عملیات -->
                    <div class="flex justify-between items-center pt-8 border-t border-gray-200 mt-8">
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <button type="button" 
                                    onclick="saveDraft()" 
                                    class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 hover-transition">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    ذخیره پیش‌نویس
                                </div>
                            </button>
                            
                            <button type="submit" 
                                    class="btn-primary text-white px-8 py-3 rounded-lg hover-transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    ذخیره و انتشار
                                </div>
                            </button>
                        </div>
                        
                        <div class="text-sm text-gray-500">
                            <span id="wordCount">{{ str_word_count(strip_tags($post->content)) }}</span> کلمه | <span id="charCount">{{ strlen($post->content) }}</span> کاراکتر
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Content word and character count
        const contentField = document.getElementById('content');
        const wordCountEl = document.getElementById('wordCount');
        const charCountEl = document.getElementById('charCount');

        function updateCounts() {
            const text = contentField.value;
            const words = text.trim() ? text.trim().split(/\s+/).length : 0;
            const chars = text.length;
            
            wordCountEl.textContent = words;
            charCountEl.textContent = chars;
        }

        contentField.addEventListener('input', updateCounts);
        updateCounts(); // Initial count

        // Simple text formatting
        function formatText(command) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const selectedText = textarea.value.substring(start, end);
            
            let formattedText;
            switch(command) {
                case 'bold':
                    formattedText = `**${selectedText}**`;
                    break;
                case 'italic':
                    formattedText = `*${selectedText}*`;
                    break;
                default:
                    formattedText = selectedText;
            }
            
            textarea.value = textarea.value.substring(0, start) + formattedText + textarea.value.substring(end);
            textarea.focus();
            textarea.setSelectionRange(start + formattedText.length, start + formattedText.length);
            updateCounts();
        }

        function insertText(text) {
            const textarea = document.getElementById('content');
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            
            textarea.value = textarea.value.substring(0, start) + text + textarea.value.substring(end);
            textarea.focus();
            textarea.setSelectionRange(start + text.length, start + text.length);
            updateCounts();
        }

        // Save as draft
        function saveDraft() {
            const form = document.getElementById('postForm');
            const publishedInput = document.createElement('input');
            publishedInput.type = 'hidden';
            publishedInput.name = 'published';
            publishedInput.value = '0';
            form.appendChild(publishedInput);
            form.submit();
        }

        // Form validation
        document.getElementById('postForm').addEventListener('submit', function(e) {
            const title = document.getElementById('title').value.trim();
            const content = document.getElementById('content').value.trim();
            const category = document.getElementById('category_id').value;
            
            if (!title || !content || !category) {
                e.preventDefault();
                alert('لطفاً عنوان، محتوا و دسته‌بندی پست را وارد کنید.');
                return false;
            }
        });
    </script>
</body>
</html>