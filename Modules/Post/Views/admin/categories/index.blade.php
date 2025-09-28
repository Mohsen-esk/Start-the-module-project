<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت دسته‌بندی‌ها</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
        }

        .header h1 {
            color: #2d3748;
            font-size: 2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header .icon {
            color: #667eea;
            font-size: 1.8rem;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            color: white;
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(229, 62, 62, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            color: white;
            padding: 8px 16px;
            font-size: 0.85rem;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(237, 137, 54, 0.3);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #c6f6d5;
            color: #2f855a;
            border-right: 4px solid #38a169;
        }

        .alert-error {
            background: #fed7d7;
            color: #c53030;
            border-right: 4px solid #e53e3e;
        }

        .search-filter {
            background: #f7fafc;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .table-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table th,
        .table td {
            padding: 15px 20px;
            text-align: right;
            border-bottom: 1px solid #e2e8f0;
        }

        .table th {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: #f8f9ff;
            transform: scale(1.01);
        }

        .table tbody tr:nth-child(even) {
            background: #f7fafc;
        }

        .table tbody tr:nth-child(even):hover {
            background: #f0f4ff;
        }

        .actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .badge-success {
            background: #c6f6d5;
            color: #2f855a;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #718096;
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #4a5568;
        }

        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            flex: 1;
            min-width: 200px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
        }

        .stat-label {
            color: #718096;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .modal h3 {
            color: #2d3748;
            margin-bottom: 15px;
            font-size: 1.3rem;
        }

        .modal p {
            color: #718096;
            margin-bottom: 25px;
        }

        .modal-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 10px;
            }

            .header {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            .search-filter {
                flex-direction: column;
            }

            .search-input {
                min-width: auto;
                width: 100%;
            }

            .table-container {
                overflow-x: auto;
            }

            .table {
                min-width: 600px;
            }

            .stats {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fas fa-folder icon"></i>
                مدیریت دسته‌بندی‌ها
            </h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                ایجاد دسته‌بندی جدید
            </a>
        </div>

        <!-- Success/Error Messages -->
        @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Statistics -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number" id="total-categories">{{ $categories->count() }}</div>
                <div class="stat-label">کل دسته‌بندی‌ها</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="recent-categories">{{ $categories->where('created_at', '>=', now()->subWeek())->count() }}</div>
                <div class="stat-label">این هفته</div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="search-filter">
            <input type="text" id="search-input" class="search-input" placeholder="جستجو در دسته‌بندی‌ها...">
            <button type="button" class="btn btn-primary" onclick="searchCategories()">
                <i class="fas fa-search"></i>
                جستجو
            </button>
        </div>

        <!-- Categories Table -->
        <div class="table-container">
            @if($categories->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>نام دسته‌بندی</th>
                        <th>نامک (Slug)</th>
                        <th>تعداد مطالب</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody id="categories-tbody">
                    @foreach($categories as $index => $category)
                    <tr class="category-row">
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $category->name }}</strong>
                            @if($category->description)
                            <br>
                            <small style="color: #718096;">{{ Str::limit($category->description, 50) }}</small>
                            @endif
                        </td>
                        <td>
                            <code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-size: 0.85rem;">
                                {{ $category->slug }}
                            </code>
                        </td>
                        <td>
                            <span class="badge badge-success">
                                {{ $category->posts_count ?? 0 }} مطلب
                            </span>
                        </td>
                        <td style="direction: ltr; text-align: right;">
                            {{ $category->created_at->format('Y/m/d') }}
                            <br>
                            <small style="color: #718096;">{{ $category->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning" title="ویرایش">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <h3>هیچ دسته‌بندی‌ای موجود نیست</h3>
                <p>برای شروع، اولین دسته‌بندی خود را ایجاد کنید.</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary" style="margin-top: 20px;">
                    <i class="fas fa-plus"></i>
                    ایجاد دسته‌بندی
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="modal">
        <div class="modal-content">
            <h3>تأیید حذف</h3>
            <p>آیا مطمئن هستید که می‌خواهید دسته‌بندی "<span id="category-name"></span>" را حذف کنید؟</p>
            <div class="modal-actions">
                <button type="button" class="btn btn-danger" onclick="deleteCategory()">
                    <i class="fas fa-trash"></i>
                    حذف
                </button>
                <button type="button" class="btn" style="background: #e2e8f0; color: #4a5568;" onclick="closeModal()">
                    انصراف
                </button>
            </div>
        </div>
    </div>

    <!-- Hidden form for deletion -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        let categoryToDelete = null;

        // Search functionality
        function searchCategories() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const rows = document.querySelectorAll('.category-row');
            
            rows.forEach(row => {
                const categoryName = row.cells[1].textContent.toLowerCase();
                const categorySlug = row.cells[2].textContent.toLowerCase();
                
                if (categoryName.includes(searchTerm) || categorySlug.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Real-time search
        document.getElementById('search-input').addEventListener('input', searchCategories);

        // Delete confirmation
        function confirmDelete(categoryId, categoryName) {
            categoryToDelete = categoryId;
            document.getElementById('category-name').textContent = categoryName;
            document.getElementById('delete-modal').style.display = 'block';
        }

        function deleteCategory() {
            if (categoryToDelete) {
                const form = document.getElementById('delete-form');
                form.action = `/admin/categories/${categoryToDelete}`;
                form.submit();
            }
        }

        function closeModal() {
            document.getElementById('delete-modal').style.display = 'none';
            categoryToDelete = null;
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('delete-modal');
            if (event.target == modal) {
                closeModal();
            }
        }

        // Auto-hide success messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Add loading state to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function() {
                if (this.type === 'submit' || this.href) {
                    this.style.opacity = '0.7';
                    this.style.pointerEvents = 'none';
                }
            });
        });
    </script>
</body>
</html>