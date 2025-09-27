<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Note Me</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom-cards.css') }}">
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #d3a7ff, #8e44ad);
            font-family: 'Helvetica', sans-serif;
            color: #2c3e50;
            overflow-x: hidden;
            direction: rtl;
            text-align: right;
        }
        .content {
            flex: 1 0 auto;
        }
        .header {
            background: linear-gradient(135deg, #8e2de2, #641d8d);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        .header.scrolled {
            backdrop-filter: blur(12px);
            background: rgba(142, 45, 226, 0.9);
        }
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }
        .logo {
            color: #ffffff;
            font-size: 1.8rem;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.3s ease, color 0.3s ease;
            white-space: nowrap;
            margin-right: 30px;
        }
        .logo:hover {
            transform: scale(1.1);
            color: #400f75;
        }
        .logo i {
            background: rgba(153, 8, 182, 0.25);
            padding: 10px;
            border-radius: 50%;
            transition: transform 0.5s ease;
        }
        .logo:hover i {
            transform: rotate(360deg);
        }
        .nav-menu ul {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
            margin: 0;
            padding: 0;
            justify-content: flex-end;
        }
        .nav-menu li a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 10px 15px;
            border-radius: 8px;
            position: relative;
        }
        .nav-menu li a:hover {
            background: rgba(128, 41, 150, 0.2);
            transform: translateY(-2px);
            color: #410581;
        }
        .nav-menu li a.active {
            background: rgba(255, 255, 255, 0.25);
            color: #ffffff;
        }
        .auth-btn {
            background: #9b59b6;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 8px;
            color: rgb(255, 255, 255);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .auth-btn:hover {
            background: #8e44ad;
            border-color: rgba(255, 255, 255, 0.5);
        }
        .user-menu {
            position: relative;
            display: inline-block;
        }
        .user-menu-toggle {
            background: rgba(194, 19, 19, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 10px 15px;
            border-radius: 8px;
            color: rgb(255, 255, 255);
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .user-menu-toggle:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(182, 46, 46, 0.5);
        }
        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: #ffffff;
            min-width: 200px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 8px 0;
            margin-top: 10px;
            display: none;
            z-index: 1001;
            font-family: 'Helvetica', sans-serif;
            font-size: 1rem;
        }
        .user-dropdown.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        .user-dropdown a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            color: #121212;
            text-decoration: none;
            transition: all 0.2s ease;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
        }
        .user-dropdown a i {
            color: #460f3e;
        }
        .user-dropdown a:hover {
            background: #ffffff;
            color: #ffffff;
        }
        .user-dropdown a:last-child {
            border-bottom: none;
            color: #ffffff;
        }
        .user-dropdown a:last-child i {
            color: #f8f8f8;
        }
        .user-dropdown a:last-child:hover {
            background: #ffe6e6;
            color: #ffffff;
        }
        .mobile-menu-toggle {
            display: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
            background: none;
            border: none;
        }
        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #8e2de2, #4a00e0);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .mobile-menu.active {
            display: block;
        }
        .mobile-menu-content {
            padding: 20px;
        }
        .mobile-menu-content a {
            display: block;
            color: #ffffff;
            text-decoration: none;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .mobile-menu-content a:hover {
            padding-left: 10px;
            background: rgba(255, 255, 255, 0.1);
        }
        .alert {
            padding: 15px 20px;
            margin: 20px auto;
            max-width: 1200px;
            border-radius: 8px;
            position: relative;
        }
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }
        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .alert-close {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            color: inherit;
        }
        .footer {
            background: linear-gradient(135deg, #d7a1f9, #6a1b9a);
            color: #ffffff;
            flex-shrink: 0;
            padding: 60px 0 40px;
        }
        .footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 40px;
            text-align: right;
        }
        .footer-section h4 {
            color: #ffffff;
            font-size: 1.3rem;
            margin-bottom: 25px;
            position: relative;
            text-align: right;
        }
        .footer-section h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(45deg, #e040fb, #7b1fa2);
            border-radius: 2px;
        }
        .footer-section ul {
            list-style: none;
            margin: 0;
            padding: 0;
            text-align: right;
        }
        .footer-section ul li {
            margin-bottom: 12px;
        }
        .footer-section ul li a {
            color: #ffffff;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            justify-content: flex-start;
        }
        .footer-section ul li a:hover {
            color: #f3e8ff;
            padding-left: 10px;
        }
        .social-link.telegram {
            background: #7b1fa2;
            padding: 5px;
            border-radius: 5px;
        }
        .social-link.instagram {
            background: linear-gradient(45deg, #e040fb, #ab47bc, #7b1fa2);
            padding: 5px;
            border-radius: 5px;
        }
        .footer-logo-section {
            text-align: right;
        }
        .footer-logo-section h3 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 15px;
        }
        .footer-logo-section p {
            color: #ffffff;
            line-height: 1.8;
            margin: 0;
            font-size: 1.1rem;
            font-style: italic;
        }
        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            width: 300px;
            max-width: 100%;
        }
        .search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .search-input:focus {
            border-color: #e040fb;
            background: rgba(255, 255, 255, 0.25);
        }
        .search-icon {
            position: absolute;
            left: 10px;
            color: #ffffff;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .search-icon:hover {
            color: #f3e8ff;
        }
        .search-results {
            position: absolute;
            top: 100%;
            right: 0;
            left: 0;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            max-height: 300px;
            overflow-y: auto;
            display: none;
            z-index: 1001;
            margin-top: 5px;
        }
        .search-results.show {
            display: block;
        }
        .search-result-item {
            display: block;
            padding: 12px 20px;
            color: #2c3e50;
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 1px solid #ecf0f1;
        }
        .search-result-item:hover {
            background: #f8f9fa;
            padding-left: 30px;
        }
        .search-result-item:last-child {
            border-bottom: none;
        }
        .mobile-search-container {
            display: none;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.1);
        }
        .mobile-search-container input {
            width: 100%;
            padding: 10px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            font-size: 1rem;
            outline: none;
        }
        .mobile-search-container input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .mobile-search-container input:focus {
            border-color: #e040fb;
        }
        @media (max-width: 1024px) {
            .footer .container {
                grid-template-columns: 1fr 1fr;
                gap: 30px;
            }
            .nav-menu ul {
                gap: 20px;
            }
            .search-container {
                width: 200px;
            }
            .logo {
                font-size: 1.6rem;
                margin-right: 20px;
            }
        }
        @media (max-width: 768px) {
            .footer .container {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .footer-section h4::after {
                left: 50%;
                transform: translateX(-50%);
            }
            .nav-menu {
                display: none;
            }
            .mobile-menu-toggle {
                display: block;
            }
            .search-container {
                display: none;
            }
            .mobile-search-container {
                display: block;
            }
            .logo {
                font-size: 1.4rem;
                gap: 6px;
                margin-right: 15px;
            }
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <header class="header" id="header">
        <div class="nav-container">
            <a href="{{ route('home') }}" class="logo">
                <i class="fas fa-sticky-note"></i>
                <span>Note Me</span>
            </a>
            <nav class="nav-menu" id="navMenu">
                <ul>
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">خانه</a></li>
                    <li><a href="{{ route('poems.index') }}" class="{{ request()->routeIs('poems.index') ? 'active' : '' }}">شعر</a></li>
                    <li><a href="{{ route('notes.index') }}" class="{{ request()->routeIs('notes.index') ? 'active' : '' }}">دلنوشته</a></li>
                    <li><a href="{{ route('books.index') }}" class="{{ request()->routeIs('books.index') ? 'active' : '' }}">کتاب</a></li>
                    <li><a href="{{ route('movies.index') }}" class="{{ request()->routeIs('movies.index') ? 'active' : '' }}">فیلم</a></li>
                    <li class="search-container">
                        <input type="text" class="search-input" id="searchInput" placeholder="جستجو...">
                        <i class="fas fa-search search-icon" onclick="performSearch()"></i>
                        <div class="search-results" id="searchResults"></div>
                    </li>
                    @auth
                        <li class="user-menu">
                            <span class="user-menu-toggle" onclick="toggleUserMenu()">
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar" style="width: 24px; height: 24px; border-radius: 50%; object-fit: cover; margin-left: 8px;">
                                {{ Auth::user()->name }}
                                <i class="fas fa-chevron-down" style="font-size: 0.8em;"></i>
                            </span>
                            <div class="user-dropdown" id="userDropdown">
                                <a href="{{ route('dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    داشبورد
                                </a>
                                <a href="{{ route('profile') }}">
                                    <i class="fas fa-user-edit"></i>
                                    پروفایل
                                </a>
                                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i>
                                    خروج
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="auth-btn">ورود</a></li>
                    @endauth
                </ul>
            </nav>
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="mobile-menu" id="mobileMenu">
            <div class="mobile-search-container">
                <input type="text" class="mobile-search-input" id="mobileSearchInput" placeholder="جستجو...">
            </div>
            <div class="mobile-menu-content">
                <a href="{{ route('home') }}">خانه</a>
                <a href="{{ route('poems.index') }}">شعر</a>
                <a href="{{ route('notes.index') }}">دلنوشته</a>
                <a href="{{ route('books.index') }}">کتاب</a>
                <a href="{{ route('movies.index') }}">فیلم</a>
                @auth
                    <a href="{{ route('dashboard') }}">داشبورد</a>
                    <a href="{{ route('profile') }}">پروفایل</a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">خروج</a>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mobile-auth">ورود</a>
                @endauth
            </div>
        </div>
    </header>

    <div class="content">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
                <button type="button" class="alert-close" onclick="this.parentElement.style.display='none';">×</button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
                <button type="button" class="alert-close" onclick="this.parentElement.style.display='none';">×</button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="footer">
        <div class="container">
            <div class="footer-section footer-logo-section">
                <h3>Note Me</h3>
                <p>مینویسم ...<br>چون!<br>من عاشق شدم...</p>
            </div>
            <div class="footer-section about-us">
                <h4>درباره ما</h4>
                <ul>
<li><a href="{{ route('about') }}"><i class="fas fa-angle-right"></i> اینجا کجاست</a></li>         
<li><a href="{{ route('who.am.i') }}"><i class="fas fa-angle-right"></i> من کیم</a></li>        
            <li><a href="#"><i class="fas fa-angle-right"></i> راهنما</a></li>
                </ul>
            </div>
            <div class="footer-section content">
                <h4>محتوای ما</h4>
                <ul>
                    <li><a href="{{ route('poems.index') }}"><i class="fas fa-angle-right"></i> شعر</a></li>
                    <li><a href="{{ route('notes.index') }}"><i class="fas fa-angle-right"></i> دلنوشته</a></li>
                    <li><a href="{{ route('books.index') }}"><i class="fas fa-angle-right"></i> کتاب</a></li>
                    <li><a href="{{ route('movies.index') }}"><i class="fas fa-angle-right"></i> فیلم</a></li>
                </ul>
            </div>
            <div class="footer-section contact-info">
                <h4>راه‌های ارتباطی</h4>
                <ul>
                    <li><a href="{{ route('contact') }}"><i class="fas fa-angle-right"></i> تماس با ما</a></li>
                    <li><a href="#" class="social-link telegram"><i class="fab fa-telegram"></i> تلگرام</a></li>
                    <li><a href="#" class="social-link instagram"><i class="fab fa-instagram"></i> اینستاگرام</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        document.getElementById('mobileMenuToggle').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            const icon = this.querySelector('i');
            mobileMenu.classList.toggle('active');
            if (mobileMenu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('show');
        }

        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userDropdown');
            if (userMenu && !userMenu.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        const searchInput = document.getElementById('searchInput');
        const mobileSearchInput = document.getElementById('mobileSearchInput');
        const searchResults = document.getElementById('searchResults');

        function performSearch() {
            const query = searchInput.value.trim().toLowerCase() || mobileSearchInput.value.trim().toLowerCase();
            searchResults.innerHTML = '';
            if (query) {
                fetch(`{{ route('home.quick-search') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.results && data.results.length > 0) {
                            data.results.forEach(item => {
                                const resultItem = document.createElement('a');
                                resultItem.classList.add('search-result-item');
                                resultItem.href = item.url;
                                resultItem.innerHTML = `<strong>${item.category}:</strong> ${item.title}`;
                                searchResults.appendChild(resultItem);
                            });
                            searchResults.classList.add('show');
                        } else {
                            const noResult = document.createElement('div');
                            noResult.classList.add('search-result-item');
                            noResult.textContent = 'نتیجه‌ای یافت نشد';
                            searchResults.appendChild(noResult);
                            searchResults.classList.add('show');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                        const errorItem = document.createElement('div');
                        errorItem.classList.add('search-result-item');
                        errorItem.textContent = 'خطا در جستجو';
                        searchResults.appendChild(errorItem);
                        searchResults.classList.add('show');
                    });
            } else {
                searchResults.classList.remove('show');
            }
        }

        searchInput.addEventListener('input', performSearch);
        mobileSearchInput.addEventListener('input', performSearch);

        document.addEventListener('click', function(event) {
            if (!searchResults.contains(event.target) && !searchInput.contains(event.target) && !mobileSearchInput.contains(event.target)) {
                searchResults.classList.remove('show');
            }
        });

        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                window.location.href = `{{ route('search') }}?q=${encodeURIComponent(searchInput.value)}`;
            }
        });
        mobileSearchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                window.location.href = `{{ route('search') }}?q=${encodeURIComponent(mobileSearchInput.value)}`;
            }
        });
    </script>
</body>
</html>
```