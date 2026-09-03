<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('page-title', 'Dashboard') - Admin - {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    @stack('styles')
</head>
<body class="admin-body">
    @php $user = auth()->user(); @endphp

    <div class="admin-shell">
        <div class="admin-overlay" id="adminOverlay"></div>

        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar__brand">
                <a href="{{ route('home') }}" class="admin-sidebar__brand-logo">
                    <x-logo class="admin-sidebar__brand-logo-img d-block" />
                </a>
                <span class="admin-sidebar__brand-tag">Admin Panel</span>
            </div>

            <nav class="admin-nav">
                <p class="admin-nav__label">Overview</p>
                <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 8.333 10 2.5l7.5 5.833V16.5a1 1 0 0 1-1 1h-4.167v-5.417H7.667V17.5H3.5a1 1 0 0 1-1-1V8.333Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                    Dashboard
                </a>

                <p class="admin-nav__label">Management</p>
                <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13.333 17.5v-1.667a3.333 3.333 0 0 0-3.333-3.333H4.167a3.333 3.333 0 0 0-3.334 3.333V17.5M17.5 17.5v-1.667a3.333 3.333 0 0 0-2.5-3.226M11.667 2.559a3.333 3.333 0 0 1 0 6.455M9.167 9.167a3.333 3.333 0 1 0 0-6.667 3.333 3.333 0 0 0 0 6.667Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Users
                </a>
                <span class="admin-nav-link is-disabled">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 6.25 10 2.5l7.5 3.75-7.5 3.75-7.5-3.75Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        <path d="M2.5 6.25V13.75L10 17.5l7.5-3.75V6.25M10 10v7.5" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                    Products
                    <span class="admin-soon">Soon</span>
                </span>
                <span class="admin-nav-link is-disabled">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.5 5h15M5 5V3.333A1.667 1.667 0 0 1 6.667 1.667h6.666A1.667 1.667 0 0 1 15 3.333V5m2.5 0-.833 11.25A1.667 1.667 0 0 1 15 17.917H5a1.667 1.667 0 0 1-1.667-1.667L2.5 5h15Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                    </svg>
                    Orders
                    <span class="admin-soon">Soon</span>
                </span>
            </nav>

            <div class="admin-sidebar__footer">
                <a href="{{ route('admin.profile.edit') }}" class="admin-sidebar__user admin-sidebar__user--link">
                    <span class="admin-avatar">
                        @if ($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                        @else
                            {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                        @endif
                    </span>
                    <div>
                        <div class="admin-sidebar__user-name">{{ $user->name }}</div>
                        <div class="admin-sidebar__user-role">{{ $user->email }}</div>
                    </div>
                </a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="admin-logout-btn">
                        <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M7.5 17.5h-3.333a1.667 1.667 0 0 1-1.667-1.667V4.167A1.667 1.667 0 0 1 4.167 2.5H7.5M13.333 14.167 17.5 10l-4.167-4.167M17.5 10H7.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Sign Out
                    </button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar__left">
                    <button type="button" class="admin-sidebar-toggle" id="adminSidebarToggle" aria-label="Toggle sidebar">
                        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.5 5h15M2.5 10h15M2.5 15h15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div>
                        <p class="admin-topbar__title">@yield('page-title', 'Dashboard')</p>
                        <p class="admin-topbar__subtitle">@yield('page-subtitle', 'Welcome back to your admin panel')</p>
                    </div>
                </div>

                <div class="admin-topbar__right">
                    <span class="admin-topbar__pill">
                        <svg width="14" height="14" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 1.667 3.75 4.167v4.958c0 3.158 2.667 6.117 6.25 7.208 3.583-1.091 6.25-4.05 6.25-7.208V4.167L10 1.667Z" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/>
                        </svg>
                        <span>Administrator</span>
                    </span>
                    <a href="{{ route('admin.profile.edit') }}" class="admin-avatar admin-avatar--link" title="Edit profile" aria-label="Edit profile">
                        @if ($user->avatar_url)
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}">
                        @else
                            {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                        @endif
                    </a>
                </div>
            </header>

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        (function () {
            var sidebar = document.getElementById('adminSidebar');
            var overlay = document.getElementById('adminOverlay');
            var toggle = document.getElementById('adminSidebarToggle');

            function closeSidebar() {
                sidebar.classList.remove('is-open');
                overlay.classList.remove('is-open');
            }

            toggle.addEventListener('click', function () {
                sidebar.classList.toggle('is-open');
                overlay.classList.toggle('is-open');
            });

            overlay.addEventListener('click', closeSidebar);
        })();
    </script>

    @stack('scripts')
</body>
</html>
